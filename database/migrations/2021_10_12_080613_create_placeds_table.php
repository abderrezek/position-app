<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placeds', function (Blueprint $table) {
            $table->id();

            $table->uuid('uuid')->unique();
            $table->decimal('lat', 11, 8);
            $table->decimal('lng', 11, 8);
            $table->integer('zoom');
            $table->string('email')->nullable();
            $table->string('message')->nullable();
            $table->string('url')->nullable();
            $table->time('time')->nullable();
            $table->integer('count')->default(0);

            $table->timestamps();
        });

        Schema::create('placed_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained("users");
            $table->foreignId('placed_id')
                ->constrained("placeds")
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('placeds');
        Schema::dropIfExists('placed_users');
    }
}
