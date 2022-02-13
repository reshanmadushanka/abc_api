<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'first_name', 'last_name', 'status'
    ];

    public function phone(){
        return $this->hasMany(CustomerPhone::class, 'customerId', 'id');
    }
}
