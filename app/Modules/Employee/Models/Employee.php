<?php

namespace App\Modules\Employee\Models;

use App\Modules\Company\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'position',
        'company_id',
    ];

    public function company()
    {
        return $this->hasMany(Company::class);
    }
}
