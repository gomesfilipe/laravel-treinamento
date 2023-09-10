<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface MyUserRepositoryInterface
{
  public function store(array $attributes, bool $isAdmin)/*: User*/;

  public function getAll();

  public function get(int $id): User|null;

  public function update(int $id, array $attributes): User;

  public function delete(int $id);

  public function getCompanies(int $id);
}
