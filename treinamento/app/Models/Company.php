<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'cnpj',
        'address_id',
    ];

    public function address() {
        // chave estrangeira fica do lado belongsTo
        return $this->belongsTo(Address::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
