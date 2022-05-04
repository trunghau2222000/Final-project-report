<?php

namespace App\Modules\Company\Repositories;

use App\Modules\Company\Models\Company;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;



class CompanyRepository implements CompanyRepositoryInterface
{
    public function create($validated)
    {
        return Company::create($validated);
    }

    public function getAll()
    {
        return Company::all();
    }

    public function updateById($validated, $id)
    {
        return Company::where('id', $id)
                ->update([
                    'name'    =>  $validated['name'],
                    'address' =>  $validated['address']
        ]);
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
