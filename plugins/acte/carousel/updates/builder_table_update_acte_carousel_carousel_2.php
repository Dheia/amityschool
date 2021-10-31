<?php namespace Acte\Carousel\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateActeCarouselCarousel2 extends Migration
{
    public function up()
    {
        Schema::table('acte_carousel_carousel', function($table)
        {
            $table->string('link_name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('acte_carousel_carousel', function($table)
        {
            $table->dropColumn('link_name');
        });
    }
}
