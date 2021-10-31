<?php namespace Acte\Carousel;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
      return [
        'Acte\Carousel\Components\Carousel' => 'carousel',
      ];
    }

    public function registerSettings()
    {
    }
}
