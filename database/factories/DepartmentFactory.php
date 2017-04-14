<?php
$factory->define(App\Department::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        'name' => $faker->unique()->departmentName,
        'phone' => $faker->unique()->phoneNumber,
        'primary_orgcode' => $faker->unique()->numberBetween($min = 25000, $max = 26000),
        'email' => $faker->unique()->safeEmail,
        'primary_contact' => $faker->unique()->name($gender = null|'male'|'female'),
    ];
    return $data;
});
