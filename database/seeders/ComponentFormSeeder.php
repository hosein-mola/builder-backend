<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Form;
use App\Models\Component;
use Symfony\Component\Uid\Ulid;

class ComponentFormSeeder extends Seeder
{
    public function run()
    {
        // Get all forms and components
        $forms = Form::all();
        $components = Component::all();

        // Seed component_form entries
        foreach ($forms as $form) {
            foreach ($components as $component) {
                $form->components()->attach($component->id);
            }
        }
    }
}
