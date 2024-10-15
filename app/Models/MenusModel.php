<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenusModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'module',
        'slug',
        'icon',
        'url',
        'parent_id',
        'order',
        'status',
    ];

    protected $guarded = [];

    protected $table = 'menus';
    
    public function parent()
    {
        return $this->belongsTo(MenusModel::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(MenusModel::class, 'parent_id', 'id');
    }
}
