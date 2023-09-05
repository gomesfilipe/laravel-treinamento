<?php

namespace App\Repositories\Interfaces;

use App\Models\Address;

interface AddressRepositoryInterface
{
  public function store(array $attributes): Address;

  public function getAll();

  public function get(int $id): Address;

  public function update(int $id, array $attributes): Address;

  public function delete(int $id);
}
