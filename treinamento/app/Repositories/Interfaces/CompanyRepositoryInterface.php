<?php

namespace App\Repositories\Interfaces;

use App\Models\Company;

interface CompanyRepositoryInterface
{
  public function store(array $attributes): Company;

  public function getAll();

  public function get(int $id): Company;

  public function update(int $id, array $attributes): Company;

  public function delete(int $id);

  public function getUsers(int $id);

  public function addUser(int $companyId, int $userId);
}
