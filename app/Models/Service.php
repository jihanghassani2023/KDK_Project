<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'is_active'
    ];

    public function Queue()
    {
        return $this->hasMany(Queue::class);
    }
}
