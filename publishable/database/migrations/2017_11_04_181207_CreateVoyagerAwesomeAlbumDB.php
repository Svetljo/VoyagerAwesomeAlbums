<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoyagerAwesomeAlbumDB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('voyager_albums', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('author')->nullable()->default(0);
            $table->string('cover_image');
            $table->string('slug')->unique();
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });

        Schema::create('voyager_albums_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voyager_albums_id')->unsigned()->index();
            $table->foreign('voyager_albums_id')->references('id')->on('voyager_albums')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->integer('author')->nullable()->default(0);
            $table->text('image');
            $table->text('thumbnail');
            $table->integer('sort')->default(1);
            $table->timestamps();
        });

        //migration add
        Schema::create('voyager_albums_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('	name')->unsigned()->index();
            $table->foreign('voyager_albums_id')->references('id')->on('voyager_albums')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->text('image');
            $table->text('thumbnail');
            $table->integer('sort')->default(1);
            $table->timestamps();
        });
        Schema::create('voyager_albums_rows', function (Blueprint $table) {
            $table->increments('id');

            $table->string('field');
            $table->string('type');
            $table->string('display_name');
            $table->boolean('required')->default(false);

            $table->text('details')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voyager_albums_image');
        Schema::dropIfExists('voyager_albums');
    }
}
