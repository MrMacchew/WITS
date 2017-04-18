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
    $data = [
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
    // dd($data);
    return $data;
});


$factory->define(App\Asset::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        'room_id' => $faker->buildingNumber(), // NOTE: How are we doing room numbers with alphabets -  202A, 202B
        'name' => $faker->word(),
        'manufacturer' => $faker->word(),
        'model' => $faker->randomElement($array = array ('iPad','Computer','Laptop', 'Extron', 'Projector', 'Camera')),
        'replacement_id' => $faker->numberBetween($min =1, $max=50),
        'description' => $faker->sentence(),
        'weber_inventory_tag' => $faker->unique()->regexify('[W][0-9]{9}'), // ^[a-zA-Z][0-9]{7}$
        'acquisition_date' => $faker->date($format='Y-m-d', $max='now'),
        'cost' => $faker->numberBetween($min=50, $max=3000) . "." . $faker->randomDigit() . $faker->randomDigit()  ,
        'serial_number' => $faker->unique()->regexify('[0-9]{2}-[0-9]{5}-[0-9]{6}'),
        'po_number' => $faker->word(), // NOTE: What does a purchase order number look like
        'checkoutable' => $faker->boolean(),
        'category_id' => $faker->randomDigit(),
        'created_at' => $faker->date(),
        'updated_at' => $faker->date(),
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
        'campus_id' => $faker->unique()->randomDigit()+1,
        'name' => $faker->unique()->word(),
        'latlong' => json_encode("{'lat': ". $faker->unique()->latitude .", 'long': ".$faker->unique()->longitude ."}")
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
    // dd($data);
    return $data;
});

$factory->define(App\Campus::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id'=> null,
        'name' =>  $faker->unique()->word(),
        'campus_code' => $faker->unique()->regexify('\w{3}_\d{3}')
    ];
    // dd($data);
    return $data;
});

