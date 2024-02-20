<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchManagerEmployees;
use App\Http\Requests\TaskValidation;
use App\Http\Resources\Api\EmployeeResource;
use App\Http\Resources\Api\TaskResource;
use App\Traits\ApiResponseTrait;
use App\Services\TaskService;

class TasksController extends Controller
{
    use ApiResponseTrait;

    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function searchForEmployees(SearchManagerEmployees $request){
        $data = $request->validated();
        $manager = auth()->user()->load('employees');
        if($manager->manager_id != null){
            return $this->sendResponse(['error' => 'You are not a manager !'] , 'fail' , 400);
        }
        $filteredEmployees = $this->taskService->searchForEmployees($data, $manager);
        return $this->sendResponse(resource_collection(EmployeeResource::collection($filteredEmployees)));
    }

    public function create(TaskValidation $request){
        $data = $request->validated();
        if(auth()->user()->manager_id != null){
            return $this->sendResponse(['error' => 'You are employee, you cant add task !'] , 'fail' , 400);
        }
        $data['manager_id'] = auth()->user()->id;
        $task = $this->taskService->createTask($data);
        return $this->sendResponse(new TaskResource($task));
    }

}



