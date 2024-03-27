<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\Form;
use App\Models\Panel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create some sample forms
        $forms = [
            ['name' => 'Form A', 'parent_id' => null],
            ['name' => 'Form B', 'parent_id' => null],
            ['name' => 'Form C', 'parent_id' => null],
            // Add more sample forms as needed
        ];

        // Insert data into the forms table and assign panels
        foreach ($forms as $form) {
            $createdForm = Form::create($form);

            // Assign panels to forms
            $components = Component::inRandomOrder()->take(rand(1, 3))->get(); // Assuming each form can have 1 to 3 components
            $createdForm->components()->attach($components);
        }
    }
}
