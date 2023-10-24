<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoItemResource;
use App\Repositories\TodoItemRepository;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{
    private TodoItemRepository $todoItemRepository;

    public function __construct(TodoItemRepository $todoItemRepository) 
    {
        $this->todoItemRepository = $todoItemRepository;
    }

    public function index()
    {
        return TodoItemResource::collection($this->todoItemRepository->getAll());
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'description' => 'required|max:255',
        ]);

        return new TodoItemResource($this->todoItemRepository->create($data));
    }

    public function destroy($id)
    {
        return ['status' => $this->todoItemRepository->delete($id)];
    }

    public function toggleCompleted($id)
    {
        return new TodoItemResource($this->todoItemRepository->toggleCompleted($id));
    }
}