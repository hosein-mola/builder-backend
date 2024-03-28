<?php

namespace Database\Seeders;

use App\Models\Form;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create some sample forms
        $forms = [
            [
                'name' => 'Form A',
                'description' => 'Description for Form A',
                'published' => false,
                'visit' => 10,
                'share_url' => Str::uuid()->toString(),
            ],
            [
                'name' => 'Form B',
                'description' => 'Description for Form B',
                'published' => false,
                'visit' => 5,
                'share_url' => Str::uuid()->toString(),
            ],
            [
                'name' => 'Form C',
                'description' => 'Description for Form C',
                'published' => true,
                'visit' => 20,
                'share_url' => Str::uuid()->toString(),
            ],
            // Add more sample forms as needed
        ];

        // Insert data into the forms table
        foreach ($forms as $form) {
            Form::create($form);
        }
    }
}
