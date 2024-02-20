<?php
namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Department;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;

class DeprartmentService{

    public function getAllDepartments() :Paginator{
        return  Department::with('manager')->simplepaginate();
    }

    public function createDepartment($data) :Object{
        return Department::create($data);
    }

    public function editDepartment($data, $department) :bool{
        $department->update($data);
        return true;
    }

    public function searchEmployees($query):Paginator{
        $rows = Employee::where('first_name', 'like' , "%$query%")
                ->where('last_name', 'like' , "%$query%")
                ->where('salary', 'like' , "%$query%")
                ->where('salary', 'like' , "%$query%")
                ->simplepaginate();
        return $rows;
    }



}
