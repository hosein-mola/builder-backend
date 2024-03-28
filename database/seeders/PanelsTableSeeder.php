<?php

namespace Database\Seeders;

use App\Models\Component;
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

        // Define the maximum size of components
        $maxComponents = 20; // Change this to your maximum size

        // Define the number of panels per component
        $panelsPerComponent = 1; // One panel for each component

        // Define the batch size for insertion
        $batchSize = 1; // Adjust the batch size as needed

        // Initialize a counter for total panels inserted
        $totalPanelsInserted = 0;

        // Iterate over each component ID and create a panel
        for ($componentId = 1; $componentId <= $maxComponents; $componentId++) {
            $panels = [];
            for ($i = 0; $i < $panelsPerComponent; $i++) {
                $component = Component::find($componentId);
                if($component->type == 'panel') {
                    $panels[] = [
                        'title' => $faker->sentence(),
                        'cols' => (string) $faker->numberBetween(1, 5),
                        'span' => (string) $faker->numberBetween(1, 3),
                        'component_id' => $componentId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    // Insert panels in batches
                    if (count($panels) >= $batchSize) {
                        DB::table('panels')->insert($panels);
                        $totalPanelsInserted += count($panels);
                        error_log("Inserted $totalPanelsInserted panels.");
                        $panels = [];
                    }
                };
            }
        }
    }
}
