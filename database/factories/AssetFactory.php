<?php
$factory->define(App\Asset::class, function (Faker\Generator $faker) {
    $faker->seed(1);
    $data = [
        'id' => null,
        // NOTE: How are we doing room numbers with alphabets
        // 202A, 202B
        'room_id' => $faker->buildingNumber(),
        'name' => $faker->word(),
        'manufacturer' => $faker->word(),
        'model' => $faker->randomElement($array = array ('iPad','Computer','Laptop', 'Extron', 'Projector', 'Camera')),
        // NOTE: talk about this in the meeting for foreign keys
        'replacement_id' => $faker->numberBetween($min =1, $max=50),
        'description' => $faker->sentence(),
        // ^[a-zA-Z][0-9]{7}$
        'weber_inventory_tag' => $faker->unique()->regexify('[W][0-9]{9}'),
        'acquisition_date' => $faker->date($format='Y-m-d', $max='now'),
        'cost' => $faker->numberBetween($min=50, $max=3000),
        'serial_number' => $faker->unique()->regexify('[0-9]{2}-[0-9]{5}-[0-9]{6}'),
        // NOTE: What does a purchase order number look like
        'po_number' => $faker->word(),
        'category_id' => $faker->randomDigit(),
        'checkoutable' => $faker->boolean(),
    ];
    return $data;
});
