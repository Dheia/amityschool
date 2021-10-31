<?php

namespace Pkurg\InstagramGallery\Models;

use Model;

class Settings extends Model
{

    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'instagram_gallery_settings';

    public $settingsFields = 'fields.yaml';

    protected $cache = [];

    

}
