<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getAllUsers(Request $request) {
        try {
            $users = User::query()->get();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Cant retrieve users',
                    'data' => $users
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error('Users cant be retrieved: '. $th->getMessage());
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Users cant be retrieved',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
