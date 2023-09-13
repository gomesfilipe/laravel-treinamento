<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\User;
use App\Repositories\Interfaces\MyUserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MyUserRepository implements MyUserRepositoryInterface
{
  public function store(array $attributes, bool $isAdmin): User {
    return DB::transaction(function () use ($attributes, $isAdmin) {
      $address = Address::create($attributes);
      $attributes['address_id'] = $address->id;
      $attributes['type'] = $isAdmin ? 'admin' : 'client';
      $attributes['password'] = Hash::make($attributes['password']);
      $user = User::create($attributes);
      return $user->refresh(); // colocando valor default da imagem na model
    });
  }

  public function get(): Collection {
    return User::with(['address'])->get();
  }

  public function find(int $id): User {
    return User::with('address')->findOrFail($id);
  }

  public function update(int $id, array $attributes): User {
    return DB::transaction(function () use ($id, $attributes) {
      $user = User::findOrFail($id);
      $user->fill($attributes)->save();
      
      $address = Address::where('id', $user->address_id)->first();
      $address->fill($attributes)->save();
      
      
      return $user->load(['address']);
    });
  }

  public function delete(int $id): void {
    User::destroy($id);
  }

  public function getCompanies(int $id): Collection {
    $user = User::where('id', $id)->first();
    return $user->companies;
  }
}
