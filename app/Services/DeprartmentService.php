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

    public function search($search):Paginator{
        return Department::where(function ($q) use ($search) {
                                      $q->where('name', 'like', "%$search%");
                                     })
                                     ->withCount('employees as employees_count')
                                    ->withSum('employees as employees_sum_salary', 'salary')
                                    ->simplepaginate();
    }



}
