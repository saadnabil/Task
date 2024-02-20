<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentEmployee extends Model
{
    use HasFactory;

    protected function employee(){
        return $this->belongsTo(Employee::class);
    }

    protected function department(){
        return $this->belongsTo(Department::class);
    }

}
