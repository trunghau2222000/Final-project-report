<?php

namespace App\Modules\Employee\Repositories;


use App\Modules\Employee\Models\Employee;
use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /** Create Company
     *
     * @param $data
     * @return Array
     */
    public function create($data)
    {
        return Employee::create($data);
    }

    public function getAll()
    {
        return Employee::all();
    }
    public function updateById($data, $id)
    {
        return Employee::find($id)
                        ->update($data);
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
