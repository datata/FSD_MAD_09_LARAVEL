<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'Task created successfully',
                'data' => 'data'
            ],
            Response::HTTP_CREATED
        );
    }

    public function getAllTasks(Request $request)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'Retrieved Tasks successfully',
                'data' => 'data'
            ],
            Response::HTTP_OK
        );
    }

    public function updateTaskById(Request $request, $id)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'Task updated successfully',
                'data' => 'data'
            ],
            Response::HTTP_OK
        );
    }

    public function deleteTaskById(Request $request, $id)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'Task deketed successfully',
                'data' => 'data'
            ],
            Response::HTTP_OK
        );
    }
}
