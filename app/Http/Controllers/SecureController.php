<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class SecureController extends Controller
{

    /**
     * Carga la información del certificado de la web
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSecure(Request $request)
    {
        try {

            $message = 'Certificado cargado con éxito';
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'message' => $message,
            'data' => []
        ], Response::HTTP_OK);
    }
}