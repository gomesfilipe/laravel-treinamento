<?php

namespace App\Repositories\Interfaces;

use App\Models\Address;
use Illuminate\Support\Collection;

interface AddressRepositoryInterface
{
  public function store(array $attributes): Address;

  public function get(): Collection;

  public function find(int $id): Address;

  public function update(int $id, array $attributes): Address;

  public function delete(int $id): void;
}
