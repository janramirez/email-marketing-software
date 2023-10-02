<?php

namespace Database\Seeders\Automation;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutomationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoUser = $this->demoUser();
        $automation = Automation::create([
            'name' => 'Add To NewsLetter',
            'user_id' => $demoUser->id,
        ]);

        $automation->steps()->create([
            'type' => 
        ])
    }
}
