<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\MyUserRepositoryInterface;
use App\Repositories\AddressRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\MyUserRepository;

class RepositoryProvider extends ServiceProvider
{
  public array $bindings = [
    AddressRepositoryInterface::class => AddressRepository::class,
    CompanyRepositoryInterface::class => CompanyRepository::class,
    MyUserRepositoryInterface::class => MyUserRepository::class,
  ];
}
