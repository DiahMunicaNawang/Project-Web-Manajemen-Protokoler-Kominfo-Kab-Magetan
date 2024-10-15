<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'location',
        'dinas',
        'file_pdf',
        'start_date',
        'end_date',
    ];
}
