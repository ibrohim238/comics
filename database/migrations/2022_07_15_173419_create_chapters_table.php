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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('volume');
            $table->float('number');
            $table->string('name');
            $table->foreignId('manga_id')->constrained();
            $table->foreignId('team_id')->nullable()->constrained();
            $table->float('price')->nullable();
            $table->timestamp('free_at')->nullable();
            $table->timestamps();

            $table->unique(['volume', 'number', 'manga_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chapters');
    }
};
