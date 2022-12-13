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
        Schema::create('test_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('test_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('answers_correct')->default(0);
            $table->unsignedInteger('answers_wrong')->default(0);
            $table->unsignedInteger('marks_obtained')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_sessions');
    }
};
