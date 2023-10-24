<?php

namespace App\Repositories;

use App\Interfaces\TodoItemRepositoryInterface;
use App\Models\TodoItem;

class TodoItemRepository implements TodoItemRepositoryInterface
{
    public function getAll()
    {
        return TodoItem::all();
    }

    public function create(array $data)
    {
        return TodoItem::create($data);
    }

    public function delete($id)
    {
        TodoItem::findOrFail($id)->delete();

        return true;
    }

    public function toggleCompleted($id)
    {
        $todo_item = TodoItem::findOrFail($id);

        $todo_item->completed = ! $todo_item->completed;
        $todo_item->save();

        return $todo_item;
    }
}
