<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface
{
  public function store(array $attributes): Company {
    return DB::transaction(function () use ($attributes) {
      $address = Address::create($attributes);
      $attributes['address_id'] = $address->id;
      $company = Company::create($attributes);
      return $company->load(['address']);
    });    
  }

  public function get(): Collection
  {
    return Company::with(['address'])->get();
  }

  public function find(int $id): Company {
    return Company::with('address')->findOrFail($id);
  }

  public function update(int $id, array $attributes): Company {
    return DB::transaction(function () use ($id, $attributes) {
      $company = Company::where('id', $id)->first();
      $company->fill($attributes)->save();

      $address = Address::where('id', $company->address_id)->first();
      $address->fill($attributes)->save();
      return $company->load('address');
    });
  }

  public function delete(int $id) {
    Company::destroy($id);
  }

  public function getUsers(int $id): Collection 
  {
    $company = Company::where('id', $id)->first();
    return $company->users;
  }

  public function addUser(int $companyId, int $userId): void 
  {
    $company = Company::where('id', $companyId)->first();
    $company->users()->attach($userId);
  }
}
