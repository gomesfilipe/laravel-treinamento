<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'street',
        'neighborhood',
        'city',
        'state',
    ];

    public function company() {
        return $this->hasOne(Company::class);
    }
}
