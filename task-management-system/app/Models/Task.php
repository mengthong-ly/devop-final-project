<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'due_date',
    ];

    // Additional attributes that can be set from API
    protected $appends = ['users'];

    // Store users data from API
    public $users = [];

    // Not used by UI since data comes from microservice

    /**
     * Get users associated with this task
     */
    public function getUsersAttribute()
    {
        return $this->users ?? [];
    }

    /**
     * Set users for this task
     */
    public function setUsersAttribute($users)
    {
        $this->users = $users;
    }
}
