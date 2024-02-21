<?php
namespace App\Services;
use App\Models\Task;
use Illuminate\Pagination\Paginator;

class ManagerService{

    public function createTask($data) :Object{
        if(auth()->user()->manager_id != null){
            return ['error' => 'You are employee, you cant add task !'];
        }
        $data['manager_id'] = auth()->user()->id;
        return Task::create($data);
    }

    public function listEmployeeTasks($employeeid){
        $manager = auth()->user();
        $employee = $manager->employees()->where('id', $employeeid)->with('tasks')->first();
        if(!$employee){
            return ['error' => 'You are not manager of this employee ,You cant see his/her tasks !'];
        }
        return $employee->tasks()->simplepaginate();
    }

    public function searchForEmployees($search): Paginator{
        $manager = auth()->user()->load('employees');
        if($manager->manager_id != null){
            return ['error' => 'You are not a manager !'];
        }
        return $manager->employees()
                        ->where(function ($q) use ($search) {
                                 $q->where('first_name', 'like', "%$search%")
                                ->orWhere('last_name', 'like', "%$search%")
                                ->orWhere('salary', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                        })
                        ->simplepaginate();
    }

}
