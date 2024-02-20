<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory ,SoftDeletes;

    protected $guarded = [];

    protected $date = ['deleted_at'];

    public function employee(){
        return $this->belongsTo(Employee::class)->withTrashed();
    }

    public function manager(){
        return $this->belongsTo(Employee::class , 'manager_id')->withTrashed();
    }

}
