<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface MyUserRepositoryInterface
{
  public function store(array $attributes, bool $isAdmin)/*: User*/;

  public function getAll();

  public function get(int $id): User;

  public function update(int $id, array $attributes): User;

  public function delete(int $id);
}
