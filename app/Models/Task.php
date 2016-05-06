<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    public $timestamps = true;
    protected $fillable = [
        'worker_id',
        'name',
        'status',
        'description',
        'sort',
        'time'
    ];

    public function worker()
    {
        return $this->belongsTo('App\Models\Worker');
    }

}
