<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a Faker instance
        $faker = Faker::create();

        // Define the number of records to generate
        $numberOfRecords = 5000000; // Inserting 1000 components

        // Define the batch size for insertion
        $batchSize = 10000 ;// Batch size of 100

        // Generate and insert data into the components table in batches
        for ($i = 1; $i <= $numberOfRecords; $i += $batchSize) {
            // Generate component data
            $components = [];
            for ($j = 1; $j <= $batchSize; $j++) {
                $components[] = [
                    'parentId' => null, // Assuming parentId can be null
                    'type' => $faker->randomElement(['panel', 'text']), // Define your types
                    'page' => $faker->numberBetween(1, 10), // Assuming pages can be between 1 and 10
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                error_log("Component inserted: $i + $j");
            }
            // Batch insert components
            DB::table('components')->insert($components);
            // Free memory by unsetting the components array
            unset($components);
        }
    }
}
