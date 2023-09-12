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
        $data = [];

        try {
            $x509 = new X509();
            $certificado = SslCertificate::createForHostName($url, 10, false);

            $orignalParse = parse_url($url, PHP_URL_HOST);

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

            if (count($namepart) == 2) {
                $certDomain = trim($namepart[1], '*. ');
                $checkDomain = substr($url, -strlen($certDomain));
                $tieneSSL = ($certDomain == $checkDomain);
            }
            //----------------------------------------

            openssl_x509_export($cert["options"]["ssl"]["peer_certificate"], $certInfo);

            $csr = $x509->loadX509($certInfo);

            $info = $x509->getIssuerDN(X509::DN_OPENSSL);

            $data = [
                'sitio-web'          => $x509->getDNProp('CN')[0],
                'nombre-en-certificado' => $certInfo['name'] ?? 'No es igual la URL que el nombre en certificado',
                //'tiene-ssl'         => $tieneSSL,
                'certificado-valido' => $certificado->isValid(),
                'comprobar-url' => $x509->validateURL($url),
                'firma-algoritmo' => $csr['signatureAlgorithm']['algorithm'] ?? null,
                'pais-c' => $info['C'],
                'organizacion-o' => $info['O'],
                'nombre-comun-cn' => $info['CN'],
                'valido_desde' => $certificado->validFromDate()->format('Y-M-d') ?? null,
                'valido_hasta' => $certificado->expirationDate()->format('Y-M-d') ?? null,
                'dias-expira' => $certificado->expirationDate()->diffInDays() ?? null
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
