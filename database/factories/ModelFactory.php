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
    // $faker->seed(1);
    static $password;

    $firstname = $faker->unique()->firstName;
    $lastname = $faker->unique()->lastName;
    $user = $faker->firstName . "_" . $faker->lastName;

    $data = [
        'first_name' => $firstname,
        'last_name' => $lastname,
        'username' => $user,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
    // dd($data);
    return $data;
});


$factory->define(App\Asset::class, function (Faker\Generator $faker) {
    // $faker->seed(1);
    $data = [
        'id' => null,
        'room_id' => $faker->unique(true)->numberBetween(1,11),
        'name' => $faker->unique(true)->word(),
        'manufacturer' => $faker->unique(true)->word(),
        'model' => $faker->unique(true)->randomElement($array = array ('iPad','Computer','Laptop', 'Extron', 'Projector', 'Camera')),
        'replacement_id' => $faker->unique(true)->numberBetween(1,10),
        'description' => $faker->unique(true)->sentence(),
        'weber_inventory_tag' => $faker->unique(true)->regexify('[W][0-9]{9}'), // ^[a-zA-Z][0-9]{7}$
        'acquisition_date' => $faker->date($format='Y-m-d', $max='now'),
        'cost' => $faker->numberBetween(50,3000) . "." . $faker->randomDigit() . $faker->randomDigit()  ,
        'serial_number' => $faker->unique(true)->regexify('[0-9]{2}-[0-9]{5}-[0-9]{6}'),
        'po_number' => $faker->regexify('po-[0-9]{9}'),
        'checkoutable' => $faker->boolean(),
        'category_id' => $faker->numberBetween(1,11),
        'created_at' => $faker->date(),
        'updated_at' => $faker->date(),
    ];
    // dd($data);
    return $data;
});

// $factory->state(App\Asset::class, 'asset_replacement', function($faker){
//     return [
//         'replacement_id' => $faker->unique(true)->numberBetween(1,10)
//     ];
// });

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
    // $faker->seed(1);
    $data = [
    'id' => null,
    'campus_id' => $faker->unique(true)->numberBetween(1,11),
    'name' => $faker->unique()->word(),
    'latlong' => json_encode("{'lat': ". $faker->unique()->latitude .", 'long': ".$faker->unique()->longitude ."}")
    ];
    // dd($data);
    return $data;
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Checkout::class, function (Faker\Generator $faker) {
    // $faker->seed(1);
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
        'name' => $faker->unique()->colorName(),
        'phone' => $faker->unique()->phoneNumber(),
        'primary_orgcode_id' => $faker->randomDigit(),
        'parent_department_id' => $faker->randomDigit(),
        'email' => $faker->unique()->safeEmail,
        'primary_contact_name' => $faker->unique()->name(),
    ];
    // dd($data);
    return $data;
});


$factory->define(App\Org::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id'=> null,
        'department_id' =>  $faker->randomDigit(),
        'name' =>  "org_".$faker->unique()->word(),
        'code' => $faker->unique()->regexify('\d{5}')
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



$factory->define(App\Room::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id'=> null,
        'building_id'=>1,
        'number' => $faker->unique()->regexify('\d{3}[A-Z]?'),
        'name' => $faker->word(),
        'style_id' => $faker->unique()->numberBetween(1,11),
        'capacity' => $faker->numberBetween(20,300),
        'support_id' => $faker->numberBetween(1,11),
    ];
    // dd($data);
    return $data;
});


$factory->define(App\RoomStyle::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id'=> null,
        'name' =>  $faker->unique()->word(),
    ];
    // dd($data);
    return $data;
});

$factory->define(App\Support::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        'primary_contact' => $faker->unique()->name(),
        'secondary_contact' => $faker->unique()->name()
    ];
    // dd($data);
    return $data;
});

$factory->define(App\Software::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        'title' => $faker->unique()->colorName(),
        'filename' => 'filename_'.$faker->unique()->colorName().'.jpg',
        'url' => $faker->imageUrl(640, 480, 'cats', true, 'Faker'),
        ];
    // dd($data);
    return $data;
});

$factory->define(App\AssetPropertyName::class, function (Faker\Generator $faker) {
    // $faker->seed(1);
    $data = [
        'id' => null,
        'name' => $faker->unique()->randomElement($array = array ('mac_address_wired','mac_address_wireless')),
        ];
    // dd($data);
    return $data;
});

$factory->define(App\Properties::class, function (Faker\Generator $faker) {
    // $faker->seed(1);
    $data = [
        'id' => null,
        'name_id' => $faker->numberBetween(1,11),
        'value' => $faker->unique(true)->macAddress(),
        ];
    // dd($data);
    return $data;
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    // $faker->seed(1);
    $data = [
        'id' => null,
        'name' => $faker->unique()->randomElement($array = array ('Computer','tablet')),
        'lifecycle' => $faker->numberBetween(2,4),
        ];
    // dd($data);
    return $data;
});

// $factory->define(App\Media::class, function (Faker\Generator $faker) {
//     // $faker->seed(1);
//     $data = [
//         'id' => null,
//         'name' => $faker->unique()->randomElement($array = array ('Computer','tablet')),
//         'lifecycle' => $faker->numberBetween(2,4),
//         ];
//     // dd($data);
//     return $data;
// });
