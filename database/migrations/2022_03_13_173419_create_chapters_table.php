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
            $table->integer('volume');
            $table->float('number');
            $table->string('name');
            $table->boolean('is_paid')->default(false);
            $table->foreignId('manga_id')->constrained();
            $table->unsignedInteger('order_column');
            $table->timestamps();

            $table->unique(['manga_id', 'order_column']);
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
