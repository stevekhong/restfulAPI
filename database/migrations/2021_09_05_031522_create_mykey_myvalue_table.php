<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMykeyMyvalueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mykey_myvalue', function (Blueprint $table) {
            $table->integer('mykey_id')->unsigned();
            $table->integer('myvalue_id')->unsigned();

            $table->foreign('mykey_id')->references('id')->on('mykeys')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('myvalue_id')->references('id')->on('myvalues')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['mykey_id', 'myvalue_id']);
            $table->integer( 'created_at' );
            $table->integer( 'updated_at' );
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mykey_myvalue');
    }
}
