<?php

namespace App\Modules\Employee\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Employee\Requests\CreateEmployeeRequest;
use App\Modules\Employee\Requests\UpdateEmployeeRequest;
use App\Modules\Employee\Services\Interfaces\EmployeeServiceInterface;

class EmployeeController extends Controller
{
    private $employeeServices;

    public function __construct(EmployeeServiceInterface $employeeServices)
    {
        $this->employeeServices = $employeeServices;
    }

    /**
     * get all employees
     * @return reponse
     */
    public function getAll()
    {
        return $this->employeeServices->getAll();
    }

    /**
     * create employee
     * @return reponse
     */
    public function create(CreateEmployeeRequest $requests)
    {
        return $this->employeeServices->create($requests);
    }

    /**
     * update employee to by id
     * @return reponse
     */
    public function update(UpdateEmployeeRequest $requests, $id)
    {
        return $this->employeeServices->update($requests, $id);
    }

    /**
     * delete employee to by id
     * @return reponse
     */
    public function delete($id)
    {
        return $this->employeeServices->delete($id);
    }

    /**
     * get Employees to by Company id
     * @return reponse
     */
    public function getEmployeesToByCompanyId($company_id)
    {
        return $this->employeeServices->getEmployeesToByCompanyId($company_id);
    }

    /**
     * get Employee to by id
     * @return reponse
     */
    public function getEmployee($id)
    {
        return $this->employeeServices->getEmployee($id);
    }
}
