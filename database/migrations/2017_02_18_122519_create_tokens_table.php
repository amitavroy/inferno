<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token', 20)->default(uniqid());
            $table->string('type', 100)->default('user_activation');
            $table->unsignedInteger('user_id');
            $table->timestamp('created_at')->default(\Carbon\Carbon::now());
            $table->timestamp('expiry_at')
                ->default(\Carbon\Carbon::now()->addHours(env('TOKEN_EXPIRY')));

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
