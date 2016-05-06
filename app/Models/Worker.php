<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{

    protected $table = 'workers';

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
    }

    public function getTasksByStatus($type)
    {
        return $this->tasks->where('status', $type)->sortBy('sort')->all();
    }
}
