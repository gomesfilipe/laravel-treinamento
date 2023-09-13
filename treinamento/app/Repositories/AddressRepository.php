<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AddressRepository implements AddressRepositoryInterface
{
  public function store(array $attributes): Address {
    return Address::create($attributes);
  }

  public function get(): Collection {
    return Address::all();
  }

  public function find(int $id): Address {
    return Address::where('id', $id)->first();
  }

  public function update(int $id, array $attributes): Address {
    return DB::transaction(function () use ($id, $attributes) {
      $address = Address::where('id', $id)->first();
      $address->fill($attributes)->save();
      return $address;
    });
  }

  public function delete(int $id): void {
    Address::destroy($id);
  }
}
