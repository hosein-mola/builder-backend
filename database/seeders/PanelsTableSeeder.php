<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PanelsTableSeeder extends Seeder
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

        // Fetch all component ids
        $componentIds = DB::table('components')->pluck('id')->toArray();

        // Define the number of panels per component
        $panelsPerComponent = 1; // One panel for each component

        // Define the batch size for insertion
        $batchSize = 1000; // Adjust the batch size as needed

        // Initialize a counter for total panels inserted
        $totalPanelsInserted = 0;

        // Iterate over each component ID and create a panel
        foreach ($componentIds as $componentId) {
            $panels = [];
            for ($i = 0; $i < $panelsPerComponent; $i++) {
                $panels[] = [
                    'title' => $faker->sentence(),
                    'cols' => $faker->numberBetween(1, 5),
                    'span' => $faker->numberBetween(1, 3),
                    'component_id' => $componentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Insert panels in batches
                if (count($panels) >= $batchSize) {
                    DB::table('panels')->insert($panels);
                    $totalPanelsInserted += count($panels);
                    error_log("Inserted $totalPanelsInserted panels.");
                    unset($panels);
                    $panels = [];
                }
            }
            // Insert any remaining panels
            if (!empty($panels)) {
                DB::table('panels')->insert($panels);
                $totalPanelsInserted += count($panels);
                error_log("Inserted $totalPanelsInserted panels.");
                unset($panels);
            }
        }
    }
}
