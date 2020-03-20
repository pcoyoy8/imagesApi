<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('picture_title')
                ->charset('utf8')
                ->collation('utf8_unicode_ci')
                ->nullable(false)
                ->unique();
            $table->longText('picture_url')
                ->nullable(false);
            $table->string('download_url')
                ->nullable(true);
            $table->string('picture_description')
                ->nullable(true);
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
        Schema::dropIfExists('images');
    }
}
