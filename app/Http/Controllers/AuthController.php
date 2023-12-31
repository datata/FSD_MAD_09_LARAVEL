<?php

namespace App\Http\Controllers;

use App\Mail\Welcome;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            Log::info('User register');
            // validar
            $validator = $this->validateRegisterDataUser($request);

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

            // //generar ruta de activacion de cuenta
            // $urlActivate = 'https://www.google.com/';

            // // enviar mail de bienvenida
            // $welcome = new Welcome($urlActivate, $name);
            // Mail::to($email)->send($welcome);

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
            Log::error('Error registering user: '.$th->getMessage());

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

    public function validateRegisterDataUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:100',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6|max:12'
        ]);

        return $validator;
    }

    public function login(Request $request) {
        try {
            Log::info('User login');

            // validar
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User cant be logged',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // recoger info
            $email = $request->input('email');
            $password = $request->input('password');

            $user = User::query()->where('email', $email)->first();

            if (!$user) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Email or password invalid',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // Comprobar password
            $passwordIsValid = Hash::check($password, $user->password);

            if(!$passwordIsValid) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Email or password invalid',
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // generar token
            $token = $user->createToken('apiToken')->plainTextToken;

            // devolver respuesta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'User loged successfully',
                    'data' => $user,
                    'token' => $token
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error('User cant be logged: '.$th->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'User cant be logged',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function logout(Request $request) {
        // recuperamos token
        $accessToken = $request->bearerToken();

        // Busxamos el token en la tabla correspondiente
        $token = PersonalAccessToken::findToken($accessToken);
        $token->delete();

        // alternativas
        // $request->user()->currentAccessToken()->delete();

        // $user = Auth::guard('sanctum')->user();
        // if ($user) {
        //     $user->tokens()->delete();
        // }

        // devolvemos una respuesta
        return response()->json(
            [
                'success' => true,
                'message' => 'User Logged out',
            ],
            Response::HTTP_OK
        );
    }

    public function profile(Request $request) {
        try {
            $user = auth()->user();
            // $user = User::query()->find(auth()->user()->id);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'User profile successfully',
                    'data' => $user
                ],
                Response::HTTP_OK
            );

        } catch (\Throwable $th) {
            Log::error('User profile cant be retrieved: '.$th->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'User profile cant be retrieved',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
