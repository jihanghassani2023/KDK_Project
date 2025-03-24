<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\QueueServiceProvider;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'description', 'is_active'
    ];

    public function queues()
    {
        return $this->hasMany(Queue::class);
    }
}
