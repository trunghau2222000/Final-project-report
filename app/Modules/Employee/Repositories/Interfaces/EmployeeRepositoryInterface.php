<?php

namespace App\Modules\Employee\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    public function getAll();
    public function create($validated);
    public function updateById($validated, $id);
    public function deleteById($id);
    public function getById($id);
    public function getByCompanyId($companyId);
}
