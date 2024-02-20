<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Employee extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable , SoftDeletes;

    protected $guarded = [];

    protected $date = ['deleted_at'];

    protected $hidden = [
        'password',
    ];

    public function manager(){
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function employees(){
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function departments(){
        return $this->belongsTo(Department::class, 'department_employees');
    }

    public function getFullNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getImageUrlAttribute(){
        return $this->image != null ?  url('storage/'. $this->image): null ;
    }

}
