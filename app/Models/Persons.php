<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persons extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'persons';
    const CREATED_AT = 'registered_at';

    protected $fillable = [
        'nip',
        'name',
        'email',
        'phone',
        'photo',
        'address',
        'gender',
        'user_id',
        'registered_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
