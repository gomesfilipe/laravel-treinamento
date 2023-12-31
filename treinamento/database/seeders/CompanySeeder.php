<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory(10)
            ->has(User::factory()->count(10))
            ->create();
    }
}
