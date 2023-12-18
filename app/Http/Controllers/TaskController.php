<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Error;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
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
            // $userId = $request->input('user_id');
            $userId = auth()->user()->id;

            // Guardamos en BD
            // $newTask = DB::table('tasks')->insert(
            //     [
            //         'title' => $title,
            //         'description' => $description,
            //         'user_id' => $userId
            //     ]
            // );

            $newTask = new Task();
            $newTask->title = $title;
            $newTask->description = $description;
            $newTask->user_id = $userId;
            $newTask->save();

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

    public function getAllTasksCreatedByUser(Request $request)
    {
        try {
            // TODO recuperar id user por token

            $tasks = Task::query()
                ->where('user_id', '=', auth()->user()->id)
                ->get(['id', 'title', 'status']);

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Retrieved Tasks successfully',
                    'data' => $tasks
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cant retrieve Tasks',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateTaskById(Request $request, $id)
    {
        try {
            // Validar datos
            $validator = Validator::make($request->all(), [
                'title' => 'string',
                'description' => 'string',
                'status' => 'boolean'
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Task cant be updated',
                        'error' => $validator->errors()
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            // recuperar datos
            $task = Task::query()
                ->where('user_id', auth()->user()->id)
                ->find($id);

            if(!$task) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Task not found'
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            // // tratar datos si fuera necesario
            // if($request->has('title')) {
            //     $task->title = $request->input('title');
            // }

            // if ($request->has($request->input('description'))) {
            //     $task->description = $request->input('description');
            // }

            // if ($request->has($request->has('status'))) {
            //     $task->status = $request->input('status');
            // }

            // // actualizar datos en db
            // $task->save();

            // guardamos con el metodo update
            $task->update($request->only(['title', 'description', 'status']));

            // devolver una respueta
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Task updated successfully',
                    'data' => $task
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error("Task cant be updated");
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cant update Task',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function deleteTaskById(Request $request, $id)
    {
        try {
            // recuperar id de la tarea a eliminar            

            // Validar que la tarea existe y es del usuaruo que la quiere eliminar

            // Elimnar tarea
            // $deleteTask = Task::destroy($id);

            $deleteTask = Task::query()->where('user_id', auth()->user()->id)->find($id);

            if(!$deleteTask) {
                throw new Error('Task not found');
            }

            $deleteTask->delete();

            // Devolver tarea
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Task deleted successfully',
                    'data' => $deleteTask
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            if ($th->getMessage() === 'Task not found') {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Task not found',
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            // if ($th->getMessage() === 'Call to a member function delete() on null') {
            //     return response()->json(
            //         [
            //             'success' => false,
            //             'message' => 'Task not found',
            //         ],
            //         Response::HTTP_NOT_FOUND
            //     );
            // }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Cant delete Task',
                    'error' => $th->getMessage()
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
