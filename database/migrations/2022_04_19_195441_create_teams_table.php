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
        $tableNames = config('teams.table_names');
        $columnNames = config('teams.column_names');

        Schema::create($tableNames['teams'], function (Blueprint $table)  use ($columnNames){
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable()->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['team_user'], function (Blueprint $table) use ($columnNames) {
            $table->foreignId($columnNames['user_foreign_key'])->constrained();
            $table->foreignId($columnNames['team_foreign_key'])->constrained();
            $table->string($columnNames['role']);

            $table->unique([$columnNames['team_foreign_key'], $columnNames['user_foreign_key']]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_user');
        Schema::dropIfExists('teams');
    }
};
