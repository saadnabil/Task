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
        return ['error' => 'Password or email is not correct'];
    }

    public function createEmployee($data) :Object{
        $data['password'] = Hash::make($data['password']);
        $data['image'] = FileHelper::upload_file('storage',$data['image']);
        return Employee::create($data);
    }

    public function editEmployee($request, $id)
    {
        $data = $request->validated();
        $employee = Employee::find($id);

        if (!$employee) {
            return ['error' => 'Employee is not found!'];
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['image'])) {
            $data['image'] = FileHelper::update_file('storage', $data['image'], $employee->image);
        }

        $employee->update($data);

        return $employee;
    }

    public function searchEmployees($search):Paginator{
        $rows = Employee::where('first_name', 'like', "%$search%")
                            ->orWhere('last_name', 'like', "%$search%")
                            ->orWhere('salary', 'like', "%$search%")
                            ->orWhere('email', 'like', "%$search%")
                            ->simplepaginate();
        return $rows;
    }



}
