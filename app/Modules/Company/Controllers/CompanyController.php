<?php

namespace App\Modules\Company\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Company\Requests\CreateCompanyRequest;
use App\Modules\Company\Requests\UpdateCompanyRequest;
use App\Modules\Company\Services\Interfaces\CompanyServiceInterface;

class CompanyController extends Controller
{
    private $companyService;

    public function __construct(CompanyServiceInterface $companyService)
    {
        $this->companyService = $companyService;
    }

    public function getAll()
    {
        return $this->companyService->getAll();
    }

    public function create(CreateCompanyRequest $requests)
    {
        return $this->companyService->create($requests);
    }

    public function update(UpdateCompanyRequest $requests, $id)
    {
        return $this->companyService->update($requests, $id);
    }

    public function delete($id)
    {
        return $this->companyService->delete($id);
    }

    public function getCompany($id)
    {
        return $this->companyService->getCompany($id);
    }
}
