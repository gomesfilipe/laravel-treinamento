<?php

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
  public array $bindings = [
    AddressRepositoryInterface::class => AddressRepository::class,
    CompanyRepositoryInterface::class => CompanyRepository::class,
  ];
}
