<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function createTask(Request $request)
    {
        return 'CREATE TASKS';
    }

    public function getAllTasks(Request $request)
    {
        return 'GET ALL TASKS';
    }

    public function updateTaskById(Request $request, $id)
    {
        return 'UPDATA TASKS: ' . $id;
    }

    public function deleteTaskById(Request $request, $id)
    {
        return 'UPDATA TASKS: ' . $id;
    }
}
