<?php
namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Employee;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Object_;

class EmployeeService{

    public function getAllEmployees() :Paginator{
        return  Employee::where('manager_id' , '!=' , null)->simplepaginate();
    }

    public function loginEmployee($data){
        if(auth()->guard('employee')->attempt(['password' => $data['password'],'email' => $data['email']])){
            $employee = auth()->guard('employee')->user();
            $employee['token'] = $employee->createToken('myApp')->plainTextToken;
            return $employee;
        }
        return null;
    }

    public function createEmployee($data) :Object{
        $data['password'] = Hash::make($data['password']);
        $data['image'] = FileHelper::upload_file('storage',$data['image']);
        return Employee::create($data);
    }

    public function editEmployee($data, $employee) :bool{
        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }
        if(isset($data['image'])){
            $data['image'] = FileHelper::update_file('storage',$data['image'], $employee->image);
        }
        $employee->update($data);
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
