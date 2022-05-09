<?php

namespace App\Modules\Company\Repositories;

use App\Modules\Company\Models\Company;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;



class CompanyRepository implements CompanyRepositoryInterface
{
    public function create($data)
    {
        return Company::create($data);
    }

    public function getAll()
    {
        return Company::all();
    }

    public function updateById($data, $id)
    {
        return Company::where('id', $id)
                        ->update($data);
    }

    public function deleteById($id)
    {
        return Company::where('id', $id)->delete();

    }

    public function getById($id)
    {
        return Company::find($id);
    }
}
