<?php
namespace App\Services;
use App\Models\Task;
use Illuminate\Pagination\Paginator;

class TaskService{

    public function createTask($data) :Object{
        return Task::create($data);
    }

    public function searchForEmployees($data ,$manager): Paginator{
        $query = $data['query'];
        return $manager->employees()
                        ->where(function ($q) use ($query) {
                                 $q->where('first_name', 'like', "%$query%")
                                ->orWhere('last_name', 'like', "%$query%")
                                ->orWhere('salary', 'like', "%$query%")
                                ->orWhere('email', 'like', "%$query%");
                        })
                        ->simplepaginate();
    }

}
