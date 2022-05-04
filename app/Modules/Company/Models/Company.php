<?php

namespace App\Modules\Company\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    protected $table = 'companies';
    // protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'address',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class, 'company_id');
    }
}
