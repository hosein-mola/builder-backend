<?php


namespace Database\Seeders;

use Carbon\Traits\Date;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Uid\Ulid;

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
                    'id' => Ulid::generate(\Illuminate\Support\Facades\Date::now()),
                    'parentId' => null,
                    'type' => $i * $j % 2 == 0 ? 'panel' : 'text',
                    'page' => $faker->numberBetween(1, 4),
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
