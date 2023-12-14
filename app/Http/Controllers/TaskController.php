<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
      try {
          // validar la informacion

        // recoger y tratar esa informacion si es necesario
        $title = $request->input('title');
        $description = $request->input('description');
        $userId = $request->input('user_id');

        // Guardamos en BD
        $newTask = DB::table('tasks')->insert(
            [
                'title' => $title,
                'description' => $description,
                'user_id' => $userId
            ]
        );

        // devolver una respuesta
        return response()->json(
            [
                'success' => true,
                'message' => 'Task created successfully',
                'data' => $newTask
            ],
            Response::HTTP_CREATED
        );
      } catch (\Throwable $th) {
        return response()->json(
            [
                'success' => false,
                'message' => 'Cant create Task',
                'error' => $th->getMessage()
            ],
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
      }
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
