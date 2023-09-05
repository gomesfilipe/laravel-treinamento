<?php

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\Interfaces\AddressRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
  public array $bindings = [
    AddressRepositoryInterface::class => AddressRepository::class,
  ];
}
