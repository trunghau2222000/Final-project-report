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

    /**
     * get list all Companies
     *
     * @return reponse
     */
    public function getAll()
    {
        return $this->companyService->getAll();
    }

   /**
     * Create Company
     *
     * @param $requests
     * @return repons
     */
    public function create(CreateCompanyRequest $requests)
    {
        return $this->companyService->create($requests);
    }

    /**
     * Update company to by id
     *
     * @param $requests, $id
     * @return reponse
     */
    public function update(UpdateCompanyRequest $requests, $id)
    {
        return $this->companyService->update($requests, $id);
    }

    /**
     * Delete company to by id
     *
     * @param  $id
     * @return reponse
     */
    public function delete($id)
    {
        return $this->companyService->delete($id);
    }

    /**
     * get company to by id
     *
     * @param  $id
     * @return reponse
     */
    public function getCompany($id)
    {
        return $this->companyService->getCompany($id);
    }
}
