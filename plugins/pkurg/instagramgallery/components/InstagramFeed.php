<?php namespace Pkurg\InstagramGallery\Components;

use Cache;
use Cms\Classes\ComponentBase;
use Pkurg\InstagramGallery\Models\Settings;

class InstagramFeed extends ComponentBase
{

    public $key = 'pkurg-insta-feed';

    public $tkey = 't-pkurg-insta-feed';

    public $propkey = 'pkurg-insta-feed-prop';

    public $p_instagram_feed;

    public $p_instagram_feed_need_update;

    public $p_instagram_feed_need_update_t;

    public $unikey;

    public $user;

    public $postcount;

    public $period;

    public $img_size;

    public $img_size_index;

    public $sizes = [
        '0' => '150x150',
        '1' => '240x240',
        '2' => '320x320',
        '3' => '480x480',
        '4' => '640x640',
    ];

    public $fontsize;

    public $textlen;

    public function componentDetails()
    {
        return [
            'name' => 'InstagramFeed Component',
            'description' => 'Show Instagram feed o page',
        ];
    }

    public function defineProperties()
    {
        return [

            'size' => [
                'title' => 'Images size',
                'group' => 'Thumbnail settings',
                'type' => 'dropdown',
                'default' => '1',
                'placeholder' => 'Select size',
                'options' => $this->sizes,
            ],
            'fontsize' => [
                'title' => 'Font size',
                'group' => 'Thumbnail settings',
                'description' => 'Caption font size',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'default' => 14,
                'validationMessage' => 'The property can contain only numeric symbols',
            ],
            'textlen' => [
                'title' => 'Caption text lenght',
                'group' => 'Thumbnail settings',
                'description' => 'Caption text lenght',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'default' => 80,
                'validationMessage' => 'The property can contain only numeric symbols',
            ],
            'postcount' => [
                'title' => 'Post Count (max 20 posts)',
                'description' => 'Post count in gallery (max 20 posts)',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'default' => 20,
                'validationMessage' => 'The Post Count property can contain only numeric symbols',

            ],
            'period' => [
                'title' => 'Update period',
                'description' => 'Update period in hours',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'default' => 24,
                'validationMessage' => 'The Post Count property can contain only numeric symbols',

            ],
            'user' => [
                'title' => 'User name',
                'description' => 'Username whose posts will be shown',
                'type' => 'string',
                'default' => 'instagram',

            ],

        ];
    }

    public function prepare_vars()
    {

        $this->img_size_index = $this->property('size', 1);
        $this->img_size = substr($this->sizes[$this->property('size', 1)], 0, 3);
        $this->fontsize = $this->property('fontsize', 1);
        $this->textlen = $this->property('textlen', 1);
        $unikey = $this->alias . $this->page->id;
        $this->unikey = $unikey;
        $this->key = $this->key . $unikey;
        $this->tkey = $this->tkey . $unikey;
        $this->propkey = $this->propkey . $unikey;
        $this->user = $this->property('user', 'instagram');
        $this->period = $this->property('period', 24);
        $this->postcount = $this->property('postcount', 20);
        if ($this->postcount > 20) {
            $this->postcount = 20;
        }

    }

    public function onRun()
    {

        $this->prepare_vars();

        $props = $this->user . $this->postcount . $this->period . $this->img_size . Settings::get('login') . Settings::get('pass');

        //reset cache on change props

        if (Cache::has($this->propkey)) {

            if (Cache::get($this->propkey) != $props) {

                Cache::forget($this->key);
                Cache::forget($this->tkey);
                Cache::forever($this->propkey, $props);
            }

        } else {

            Cache::forget($this->key);
            Cache::forever($this->propkey, $props);

        }

        $period = $this->property('period', 24);

        if (Cache::has($this->key)) {

            $this->p_instagram_feed = Cache::get($this->key);

        } else {

            if (Cache::has($this->tkey)) {

                $this->p_instagram_feed = Cache::get($this->tkey);
                $this->p_instagram_feed_need_update_t = true;
            }

            $this->p_instagram_feed_need_update = true;

        }

    }

    public function burl($url)
    {

        return \Backend::url($url);

    }

}
