<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeeValidation;
use App\Http\Requests\LoginValidation;
use App\Http\Requests\SearchValidation;
use App\Http\Requests\UpdateEmployeeValidation;
use App\Http\Resources\Api\EmployeeResource;
use App\Traits\ApiResponseTrait;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;

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
        $response = $this->employeeService->loginEmployee($data);
        if(isset($response['error'])){
            return $this->sendResponse(['error' => $response['error']] ,'fail', 200);
        }
        return $this->sendResponse(new EmployeeResource($response));
    }

    public function getAllEmployees(){
        $data = $this->employeeService->getAllEmployees();
        return $this->sendResponse(resource_collection(EmployeeResource::collection($data)));
    }

    public function create(CreateEmployeeValidation $request){
        $data = $request->validated();
        $response = $this->employeeService->createEmployee($data);
        return $this->sendResponse(new EmployeeResource($response));
    }

    public function edit(UpdateEmployeeValidation $request, $id){
        $response = $this->employeeService->editEmployee($request, $id);
        if (isset($employee['error'])) {
            return $this->sendResponse(['error' => $employee['error']], 'fail', 404);
        }
        return $this->sendResponse(new EmployeeResource($response));
    }

    public function delete(Request $request, $id){
        $employee = Employee::find($id);
        if(!$employee){
            return $this->sendResponse(['error' => 'Employee is not found !'], 'fail' , 404);
        }
        $employee->delete();
        return $this->sendResponse([]);
    }

    public function search(SearchValidation $request){
        $data = $request->validated();
        $response = $this->employeeService->searchEmployees($data['query']);
        return $this->sendResponse(resource_collection(EmployeeResource::collection($response)));
    }



}



