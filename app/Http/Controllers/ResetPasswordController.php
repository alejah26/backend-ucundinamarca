<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Mail\ResetPasswordMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;


class ResetPasswordController extends Controller
{
    /**
     * Send Reset Password.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmailPassword(Request $request)
    {

        $requestData = $request->all();

        if (!$this->validateExistEmail($requestData['email'])) {
            return $this->failedResponse();
        }

        $this->send($requestData['email']);

        return $this->successResponse();
    }

    /**
     * Change Password.
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePasswordProcess(ChangePasswordRequest $request)
    {
        return $this->getPasswordReset($request)->count() > 0 ? $this->changePassword($request) : $this->tokenNotFound();
    }


    /**
     * @param $request
     * @return \Illuminate\Database\Query\Builder
     */
    private function getPasswordReset($request)
    {
        return DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->reset_token]);
    }

    private function tokenNotFound()
    {
        return response()->json([
            'error' => 'El email y/o Token es incorrecto.'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    private function changePassword($request)
    {
        $user = User::whereEmail($request->email)->first();

        $user->update(['password' => $request->password]);

        $this->getPasswordReset($request)->delete();

        return response()->json([
            'data' => 'Contraseña modificada correctamente.'
        ], Response::HTTP_CREATED);
    }


    /**
     * @param $email
     */
    public function send($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    /**
     * @param $email
     * @return mixed|string
     */
    public function createToken($email)
    {

        $oldToken = DB::table('password_resets')->where('email', $email)->first();

        if ($oldToken) {
            return $oldToken->token;
        }

        $token = Str::random(60);

        $this->saveToken($token, $email);

        return $token;
    }

    /**
     * @param $token
     * @param $email
     * @return void
     */
    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }


    /**
     * @param $email
     * @return bool
     */
    public function validateExistEmail($email)
    {
        return !!User::where('email', $email)->first();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function failedResponse()
    {
        return response()->json([
            'error' => 'Email no encontrado en nuestro sistema.'
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse()
    {
        return response()->json([
            'data' => 'Recuperación de clave enviado correctamente, revisa tu E-mail.'
        ], Response::HTTP_OK);
    }
}
