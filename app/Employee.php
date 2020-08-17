<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $appends = [
		'bonus_salary'
	];

    public function getBonusSalaryAttribute()
	{
		return $this->base_salary * $this->bonus_salary_percentage / 100;
	}
}
