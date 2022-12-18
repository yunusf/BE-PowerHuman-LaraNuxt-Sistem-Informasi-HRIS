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
        'logo',
    ];

    // make relation with table user
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // make relation with table team
    public function teams()
    {
        return $this->hasMany(Team::class, 'company_id', 'id');
    }

    // make relation with table role
    public function roles()
    {
        return $this->hasMany(Role::class, 'company_id', 'id');
    }
}
