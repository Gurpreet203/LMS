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
        Schema::create('courses', function(Blueprint $tables){
            $tables->id();
            $tables->string('title');
            $tables->text('description');
            $tables->foreignId('statuses_id');
            $tables->foreignId('user_id')->constrained()->cascadeOnDelete();
            $tables->foreignId('units_id');
            $tables->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
