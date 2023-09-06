<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyRepositoryInterface
{
  public function store(array $attributes): Company {
    return DB::transaction(function () use ($attributes) {
      $address = Address::create($attributes); // usar o repository de address?
      // $attributes[] = ['address_id' => $address->id];
      $attributes['address_id'] = $address->id;
      // dd($attributes);
      $company = Company::create($attributes);
      return $company->with(['address'])->get()->first();
    });    
  }

  public function getAll() {
    return Company::with(['address'])->get();
    // return Company::with(['address'])->withTrashed()->get();
    // Company::find(1)->restore(); // recuperar soft delete
  }

  public function get(int $id): Company {
    return Company::with('address')->find($id);
  }

  public function update(int $id, array $attributes): Company {
    return DB::transaction(function () use ($id, $attributes) {
      // dd($attributes);
      $company = Company::where('id', $id)->first();
      // dd($company);
      $company->fill($attributes)->save();
      // $company->save();

      $address = Address::where('id', $company->address_id)->first();
      $address->fill($attributes)->save();
      // $address->save();
      return $company->with('address')->get()->first();
    });
  }

  public function delete(int $id) {
    // return DB::transaction(function () use ($id) {
      $company = Company::where('id', $id)->first();
      // $company->active = false; // soft delete
      // $company->save();
      $company->delete();
    // });
  }
}
