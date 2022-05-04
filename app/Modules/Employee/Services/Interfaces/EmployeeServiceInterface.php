<?php

namespace App\Modules\Employee\Services\Interfaces;

interface EmployeeServiceInterface
{
    public function getAll();
    public function create($requests);
    public function update($requests, $id);
    public function delete($id);
    public function getEmployeesToByCompanyId($companyId);
    public function getEmployee($id);
}
