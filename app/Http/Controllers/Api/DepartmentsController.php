<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentValidation;
use App\Http\Requests\SearchEmployeeValidation;
use App\Http\Requests\UpdateEmployeeValidation;
use App\Http\Resources\Api\DepartmentResource;
use App\Http\Resources\Api\EmployeeResource;
use App\Models\Department;
use App\Traits\ApiResponseTrait;
use App\Models\Employee;
use App\Services\DeprartmentService;
use App\Services\Employee\EmployeeService;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    use ApiResponseTrait;

    private $departmentService;

    public function __construct(DeprartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function getAllDepartments(){
        $data = $this->departmentService->getAllDepartments();
        return $this->sendResponse(resource_collection(DepartmentResource::collection($data)));
    }

    public function create(DepartmentValidation $request){
        $data = $request->validated();
        $department = $this->departmentService->createDepartment($data);
        return $this->sendResponse(new DepartmentResource($department));
    }

    public function edit(DepartmentValidation $request, $id){
        $data = $request->validated();
        $department = Department::find($id);
        if(!$department){
            return $this->sendResponse(['error' => 'Department is not found !'], 'fail' , 404);
        }
        $this->departmentService->editDepartment($data, $department);
        return $this->sendResponse(new DepartmentResource($department));
    }

    public function delete(Request $request, $id){
        $department = Department::with('department_employees')->find($id);
        if(!$department){
            return $this->sendResponse(['error' => 'Department is not found !'], 'fail' , 404);
        }
        if(count($department->department_employees) > 0){
            return $this->sendResponse(['error' => 'Cant delete department has employees !'], 'fail' , 404);
        }
        $department->delete();
        return $this->sendResponse([]);
    }

    public function search(SearchEmployeeValidation $request){
        $data = $request->validated();
        $filteredRows = $this->employeeService->searchEmployees($data, $data['query']);
        return $this->sendResponse(resource_collection(EmployeeResource::collection($filteredRows)));
    }


}



