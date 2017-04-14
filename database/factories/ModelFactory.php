<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Asset::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        'room_id' => $faker->buildingNumber(),
        'name' => $faker->word(),
        'manufacturer' => $faker->word(),
        'model' => $faker->word(),
        'replacement_id' => $faker->randomDigit(),
        'description' => $faker->sentence(),
        'weber_inventory_tag' => $faker->word(),
        'acquisition_date' => $faker->word(),
        'cost' => $faker->dateTime(),
        'serial_number' => $faker->word(),
        'po_number' => $faker->word(),
        'category_id' => $faker->word(),
        'checkoutable' => $faker->boolean(),
    ];
    // dd($data);
    return $data;
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Campus::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
            'id' => null,
            'name' =>$faker->word(),
            'campus_code' => $faker->word() . "_" . $faker->randomDigit(),
    ];
    // dd($data);
    return $data;
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Building::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        'campus_id' => $faker->randomDigit(),
        'name' =>$faker->word(),
        'latlong' => json_encode("{'lat': ". $faker->latitude .", 'long': ".$faker->longitude ."}")
    ];
    // dd($data);
    return $data;
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Checkout::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        "asset_id" => $faker->randomDigitNotNull(),
        "user_id" => $faker->randomDigitNotNull(),
        "cost_code" => $faker->randomNumber(5),
        "checkout_date" => $faker->dateTime(),
        "checkin_date" => $faker->dateTime(),
    ];
    // dd($data);
    return $data;
});

