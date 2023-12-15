<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            // validar
            $validator = $this->validateDataUser($request);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User registered successfully',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // recoger info
            $email = $request->input('email');
            $password = $request->input('password');
            $name = $request->input('name');

            // tratar info
            $encryptedPassword = bcrypt($password);

            // guardarla
            $newUser = User::create(
                [
                    'email' => $email,
                    'password' => $encryptedPassword,
                    'name' => $name
                ]
            );

            // devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User registered successfully',
                    'data' => $newUser
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'User cant be registered',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function validateDataUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|max:12'
        ]);

        return $validator;
    }
}
