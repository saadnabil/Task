<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchValidation;
use App\Http\Requests\TaskValidation;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\Api\TaskResource;
use App\Services\ManagerService;
use App\Traits\ApiResponseTrait;

class ManagerController extends Controller
{
    use ApiResponseTrait;

    private $managerService;

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    public function listEmployeeTasks($employeeid){
        $response = $this->managerService->listEmployeeTasks($employeeid);
        if (isset($response['error'])) {
            return $this->sendResponse(['error' => $response['error']] , 'fail' , 200);
        }
        return ($this->sendResponse(resource_collection(TaskResource::collection($response))));
    }

    public function searchForEmployees(SearchValidation $request){
        $data = $request->validated();
        $response = $this->managerService->searchForEmployees($data['query']);
        if (isset($response['error'])) {
            return $this->sendResponse(['error' => $response['error']] , 'fail' , 200);
        }
        return $this->sendResponse(resource_collection(EmployeeResource::collection($response)));
    }

    public function create(TaskValidation $request){
        $data = $request->validated();
        $response = $this->managerService->createTask($data);
        if (isset($response['error'])) {
            return $this->sendResponse(['error' => $response['error']] , 'fail' , 200);
        }
        return $this->sendResponse(new TaskResource($response));
    }



}



