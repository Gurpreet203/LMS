<?php

use App\Models\Role;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('role_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug')->unique();
            $table->string('email')->unique();
            $table->integer('created_by');
            $table->string('gender');
            $table->bigInteger('phone');
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->boolean('email_status')->default(0);
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
