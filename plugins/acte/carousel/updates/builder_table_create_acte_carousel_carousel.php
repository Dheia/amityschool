<?php namespace Acte\Carousel\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateActeCarouselCarousel extends Migration
{
    public function up()
    {
        Schema::create('acte_carousel_carousel', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->boolean('is_active')->default(0);
            $table->integer('sort_order')->default(0);
            $table->string('title')->nullable();
            $table->string('lead')->nullable();
            $table->string('text')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('acte_carousel_carousel');
    }
}