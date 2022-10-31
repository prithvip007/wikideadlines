<?php

namespace Seeds;

use Illuminate\Database\Seeder;
use \App\Models\ExperienceLevel;

class ExperienceLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExperienceLevel::create([
            'id' => 1,
            'name' => 'Attorney',
        ]);

        ExperienceLevel::create([
            'id' => 2,
            'name' => 'Paralegal',
        ]);

        ExperienceLevel::create([
            'id' => 3,
            'name' => 'Legal Assistant',
        ]);

        ExperienceLevel::create([
            'id' => 4,
            'name' => 'Non-legal Trained Individual (pro se)',
        ]);
    }
}
