<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookListBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_list_book', function (Blueprint $table) {
            $table->integer('book_list_id');
            $table->integer('book_id');
            $table->integer('order');
            $table->foreignId('book_list_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('book_id')
                ->constrained()
                ->onDelete('cascade');
            $table->primary(['book_list_id', 'book_id']);
            $table->index('order');
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
        Schema::dropIfExists('book_list_book');
    }
}
