<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth:api', ['except' => ['getLists','login', 'signup']]);
    }

    /**
     * getLists()
     *
     * Carga la información de las listas del formulario
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLists ()
    {
        try {

            $message = __('messages.list-load-succesfully');

            $typeAccounts = \App\Helpers\get_list_details('TIPCUE');//TODO no carga el helper global

        }catch (\Exception $e) {
            $message = $e->getMessage();
        }

        return response()->json([
            'message' => $message,
            'data' => $typeAccounts
        ], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email o contraseña incorrectas.'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function signup(SignUpRequest $request)
    {
        $data = $request->all();

        $data['type_account_id'] = $data['type_id'];

        User::create($data);

        return $this->login($request);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Cierre de sesión exitoso']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        //todo type account id, por helper parametro detalle 11=company
        $aliasName = (auth()->user()->type_account_id === 11 ? auth()->user()->business_name : auth()->user()->name . ' ' . auth()->user()->lastname);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => strtoupper($aliasName),
            'email' => auth()->user()->email,//TODO TEMPORAL
        ]);
    }


}
