<?php

namespace App\Interfaces;

interface TodoItemRepositoryInterface 
{
    public function getAll();
    public function create(array $data);
    public function delete($id);
    public function toggleCompleted($id);
}
