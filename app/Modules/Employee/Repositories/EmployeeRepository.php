<?php

namespace App\Modules\Employee\Repositories;


use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function create($validated)
    {
        return Employee::create($validated);
    }

    public function getAll()
    {
        return Employee::all();
    }
    public function updateById($validated, $id)
    {
        return Employee::find($id)
                ->update([
                    'name'          =>  $validated['name'],
                    'email'         =>  $validated['email'],
                    'position'      =>  $validated['position'],
                    'company_id'    =>  $validated['company_id']
        ]);
    }

    public function deleteById($id)
    {
        return Employee::find($id)->delete();

    }

    public function getById($id)
    {
        return Employee::find($id);
    }

    public function getByCompanyId($companyId)
    {
        return Employee::where('company_id', $companyId)->get();
    }
}
