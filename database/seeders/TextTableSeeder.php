<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\Text;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Ulid\Ulid;

class TextTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Faker instance
        $faker = Faker::create();

        // Fetch all existing component IDs
        $componentIds = Component::pluck('id')->toArray();

        // Define the number of texts per component
        $textsPerComponent = 1; // One text for each component

        // Define the batch size for insertion
        $batchSize = 1; // Adjust the batch size as needed

        // Initialize a counter for total texts inserted
        $totalTextsInserted = 0;

        // Iterate over each component ID and create a text
        foreach ($componentIds as $componentId) {
            $texts = [];
            for ($i = 0; $i < $textsPerComponent; $i++) {
                $component = Component::find($componentId);
                if ($component && $component->type == 'text') {
                    $texts[] = [
                        'label' => $faker->word(),
                        'placeholder' => $faker->sentence(),
                        'helper_text' => $faker->sentence(),
                        'required' => $faker->boolean(),
                        'component_id' => $componentId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    // Insert texts in batches
                    if (count($texts) >= $batchSize) {
                        DB::table('texts')->insert($texts);
                        $totalTextsInserted += count($texts);
                        error_log("Inserted $totalTextsInserted texts.");
                        $texts = [];
                    }
                }
            }
        }
    }
}
