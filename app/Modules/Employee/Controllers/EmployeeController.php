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
     * get list all Employees
     *
     * @return reponse
     */
    public function getAll()
    {
        return $this->employeeServices->getAll();
    }

    /**
     * Create Employee
     *
     * @param $requests
     * @return reponse
     */
    public function create(CreateEmployeeRequest $requests)
    {
        return $this->employeeServices->create($requests);
    }

    /**
     * Update Employee to by id
     *
     * @param $requests, $id
     * @return reponse
     */
    public function update(UpdateEmployeeRequest $requests, $id)
    {
        return $this->employeeServices->update($requests, $id);
    }

    /**
     * Delete Employee to by id
     *
     * @param $id
     * @return reponse
     */
    public function delete($id)
    {
        return $this->employeeServices->delete($id);
    }

    /**
     * get Employees to by Company id
     *
     * @param $company_id
     * @return reponse
     */
    public function getEmployeesToByCompanyId($company_id)
    {
        return $this->employeeServices->getEmployeesToByCompanyId($company_id);
    }

    /**
     * get Employee to by id
     *
     * @param $id
     * @return reponse
     */
    public function getEmployee($id)
    {
        return $this->employeeServices->getEmployee($id);
    }
}
