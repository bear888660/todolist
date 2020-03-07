<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', '20');
        $page = $request->query('page', '1');
        $offset = ($page - 1) * $limit;
        $tasks = Task::orderBy('sort')->offset( $offset )->limit($limit)->get();
        return response(TaskResource::collection($tasks), Response::HTTP_OK);
    }

    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->all());


        //test

        return response(new TaskResource($task), Response::HTTP_CREATED);
    }

    public function show(Task $task)
    {
        //test
        return response(new TaskResource($task), Response::HTTP_OK);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->all());
        return response(new TaskResource($task), Response::HTTP_OK);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response(null, Response::HTTP_OK);
    }
}
