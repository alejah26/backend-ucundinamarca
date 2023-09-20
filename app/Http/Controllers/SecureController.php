<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use phpseclib3\File\X509;
use Spatie\SslCertificate\SslCertificate;

class SecureController extends Controller
{

    /**
     * Carga la información del certificado de la web
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecure(Request $request)
    {
        $url = $request->url;
        $tieneSSL = false;
        $error = false;
        $data = null;

        try {
            $x509 = new X509();
            $certificado = SslCertificate::createForHostName($url, 10, false);

            $orignalParse = parse_url($url, PHP_URL_HOST);
            $protocolo = parse_url($url)['scheme'];

            $get = stream_context_create([
                "ssl" => [
                    "capture_peer_cert" => true,
                    'verify_peer_name' => false //si oculto este paramtro no deja pasar algunos sitios default:false
                ]
            ]);

            $read = stream_socket_client(
                "ssl://" . $orignalParse . ":443",
                $errno,
                $errstr,
                30,
                STREAM_CLIENT_CONNECT,
                $get
            );

            $cert = stream_context_get_params($read);
            $certInfo = openssl_x509_parse($cert['options']['ssl']['peer_certificate']);

            //---------------saber si tiene nombre del certificado
            $namepart = explode('CN=', $certInfo['name']);
            $certDomain = null;

            if (count($namepart) == 2) {
                $certDomain = trim($namepart[1], '*. ');
                $checkDomain = substr($url, -strlen($certDomain));
                $tieneSSL = ($certDomain == $checkDomain) || $protocolo == 'https';
            }
            //----------------------------------------

            openssl_x509_export($cert["options"]["ssl"]["peer_certificate"], $certInfo);

            $csr = $x509->loadX509($certInfo);
            $info = $x509->getIssuerDN(X509::DN_OPENSSL);

            $data = [
                'url'          => $url,
                'nombre_en_certificado' => $x509->getDNProp('CN')[0] ?? 'No es igual la URL que el nombre en certificado',
                'tiene_ssl'         => $tieneSSL,
                'certificado_valido' => $certificado->isValid(),
                'url_valida' => $x509->validateURL($url),
                'firma_algoritmo' => $csr['signatureAlgorithm']['algorithm'] ?? null,
                'pais_c' => $info['C'],
                'organizacion_o' => $info['O'],
                'nombre_comun_cn' => $info['CN'],
                'valido_desde' => $certificado->validFromDate()->format('Y-M-d') ?? null,
                'valido_hasta' => $certificado->expirationDate()->format('Y-M-d') ?? null,
                'dias_expira' => $certificado->expirationDate()->diffInDays() ?? -1
            ];

            $message = 'Sitio verificado con éxito.';
        } catch (\Exception $e) {
            $error = true;
            $message = $e->getMessage();
        }

        return response()->json([
            'message' => $message,
            'error' => $error,
            'data' => $data
        ], Response::HTTP_OK);
    }
}
