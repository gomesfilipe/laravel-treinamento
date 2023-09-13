<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
  public function store(array $attributes): Company;

  public function get(): Collection;

  public function find(int $id): Company;

  public function update(int $id, array $attributes): Company;

  public function delete(int $id);

  public function getUsers(int $id): Collection;

  public function addUser(int $companyId, int $userId): void;
}
