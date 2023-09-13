<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface MyUserRepositoryInterface
{
  public function store(array $attributes, bool $isAdmin): User;

  public function get(): Collection;

  public function find(int $id): User;

  public function update(int $id, array $attributes): User;

  public function delete(int $id): void;

  public function getCompanies(int $id): Collection;
}
