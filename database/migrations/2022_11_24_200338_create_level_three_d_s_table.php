<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_three_d_s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');

            $table->foreignIdFor(\App\Models\LevelTwoA::class);
            $table->foreignIdFor(\App\Models\LevelTwoB::class);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('level_three_a_s');
    }
};
