<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
            'manager' => new EmployeeResource($this->manager),
        ];

        if($this->employees_count){
            $data['employees_count'] = $this->employees_count;
        }
        if($this->employees_sum_salary){
            $data['employees_sum_salary'] = $this->employees_sum_salary;
        }

        return $data;

    }
}
