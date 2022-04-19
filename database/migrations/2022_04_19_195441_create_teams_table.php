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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->timestamps();
        });

        Schema::create('team_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->timestamps();
        });

        Schema::create('team_roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('team_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('team_role_has_permissions', function (Blueprint $table) {
            $table->foreignId('team_permission_id')->references('id')->on('team_permissions');
            $table->foreignId('team_role_id')->references('id')->on('team_roles');
        });

        Schema::create('team_user_has_role', function (Blueprint $table) {
            $table->foreignId('team_user_id')->references('id')->on('team_user');
            $table->foreignId('team_role_id')->references('id')->on('team_roles');
        });

        Schema::create('teamables', function (Blueprint $table) {
            $table->foreignId('team_id')->references('id')->on('teams');
            $table->morphs('teamable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
        Schema::dropIfExists('team_users');
        Schema::dropIfExists('team_roles');
        Schema::dropIfExists('team_permissions');
        Schema::dropIfExists('team_role_has_permissions');
        Schema::dropIfExists('team_user_has_role');
        Schema::dropIfExists('teamables');
    }
};
