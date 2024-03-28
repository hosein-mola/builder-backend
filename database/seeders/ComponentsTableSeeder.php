<?php


namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfRecords = 20;
        $batchSize = 1;
        for ($i = 1; $i <= $numberOfRecords; $i += $batchSize) {
            $faker = Faker::create();
            $components = [];
            for ($j = 1; $j <= $batchSize; $j++) {
                $components[] = [
                    'parentId' => null,
                    'type' => $i * $j % 2 == 0 ? 'panel' : 'text',
                    'page' => $faker->numberBetween(1, 10),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('components')->insert($components);
            unset($components);
            unset($faker);
            error_log("Inserted $i components");
        }
    }
}
