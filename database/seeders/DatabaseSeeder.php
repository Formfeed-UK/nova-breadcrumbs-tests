<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(1)->create();

        \App\Models\LevelOne::create(["name"=>"Test-1-Level-1"])->each(function ($levelOne) {
            $levelOne->levelTwoA()->create(["name"=>"Test-1-Level-2A"])->each(function ($levelTwoA) {
                $levelTwoA->levelThreeA()->create(["name"=>"Test-1-Level-3A"]);
            });

            $levelOne->levelTwoBs()->create(["name"=>"Test-1-Level-2B"]);

            $levelOne->levelTwoC()->create(["name"=>"Test-1-Level-2C"])->each(function ($levelTwoC) {
                $levelTwoC->levelThreeB()->create(["name"=>"Test-1-Level-3B"]);
            });

            $levelOne->levelTwoD()->create(["name"=>"Test-1-Level-2D"])->each(function ($levelTwoD) {
                $levelTwoD->levelThreeC()->create(["name"=>"Test-1-Level-3C"]);
            });
        });


        \App\Models\LevelThreeD::create([
            "name"=>"Test-1-Level-3D",
            "level_two_a_id" => \App\Models\LevelTwoA::first()->id,
            "level_two_b_id" => \App\Models\LevelTwoB::first()->id,
        ]);

    }
}
