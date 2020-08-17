<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName . ' ' . $faker->lastName,
	    'base_salary' => rand (5000*10, 30000*10) / 10,
	    'bonus_salary_percentage' => 10,
	    
    ];
});
