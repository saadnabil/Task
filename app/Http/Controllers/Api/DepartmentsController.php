<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentValidation;
use App\Http\Requests\SearchValidation;
use App\Http\Resources\Api\DepartmentResource;
use App\Http\Resources\Api\EmployeeResource;
use App\Models\Department;
use App\Traits\ApiResponseTrait;
use App\Services\DeprartmentService;
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
        $department = Department::with('employees')->find($id);
        if(!$department){
            return $this->sendResponse(['error' => 'Department is not found !'], 'fail' , 404);
        }
        if($department->employees->count() > 0){
            return $this->sendResponse(['error' => 'Cant delete department has employees !'], 'fail' , 404);
        }
        $department->delete();
        return $this->sendResponse([]);
    }

    public function search(SearchValidation $request){
        $data = $request->validated();
        $response = $this->departmentService->search($data['query']);
        return $this->sendResponse(resource_collection(DepartmentResource::collection($response)));
    }


}



