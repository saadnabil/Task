<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeValidation;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\SearchEmployeeValidation;
use App\Http\Requests\UpdateEmployeeValidation;
use App\Http\Resources\Api\EmployeeResource;
use App\Traits\ApiResponseTrait;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeesController extends Controller
{
    use ApiResponseTrait;

    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function login(LoginValidation $request){
        $data = $request->validated();
        $employee = $this->employeeService->loginEmployee($data);
        if(!$employee){
            return $this->sendResponse(['error' => 'Password or email is not correct'] ,'fail', 404);
        }
        return $this->sendResponse(new EmployeeResource($employee));
    }

    public function getAllEmployees(){
        $data = $this->employeeService->getAllEmployees();
        return $this->sendResponse(resource_collection(EmployeeResource::collection($data)));
    }

    public function create(CreateEmployeeValidation $request){
        $data = $request->validated();
        $employee = $this->employeeService->createEmployee($data);
        return $this->sendResponse(new EmployeeResource($employee));
    }

    public function edit(UpdateEmployeeValidation $request, $id){
        $data = $request->validated();
        $employee = Employee::find($id);
        if(!$employee){
            return $this->sendResponse(['error' => 'Employee is not found !'], 'fail' , 404);
        }
        $this->employeeService->editEmployee($data, $employee);
        return $this->sendResponse(new EmployeeResource($employee));
    }

    public function delete(Request $request, $id){
        $employee = Employee::find($id);
        if(!$employee){
            return $this->sendResponse(['error' => 'Employee is not found !'], 'fail' , 404);
        }
        $employee->delete();
        return $this->sendResponse([]);
    }

    public function search(SearchEmployeeValidation $request){
        $data = $request->validated();
        $filteredRows = $this->employeeService->searchEmployees($data, $data['query']);
        return $this->sendResponse(resource_collection(EmployeeResource::collection($filteredRows)));
    }



}



