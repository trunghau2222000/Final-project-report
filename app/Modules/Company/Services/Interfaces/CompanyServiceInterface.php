<?php

namespace App\Modules\Company\Services\Interfaces;

interface CompanyServiceInterface
{
    public function getAll();
    public function create($requests);
    public function update($requests, $id);
    public function delete($id);
    public function getCompany($id);
}
