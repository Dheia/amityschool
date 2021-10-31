<?php namespace Pkurg\InstagramGallery;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return ['Pkurg\InstagramGallery\Components\InstagramFeed' => 'InstagramFeed'];
    }

    public function pluginDetails()
    {
        return [
            'name' => 'pkurg.instagramgallery::lang.plugin.name',
            'description' => 'pkurg.instagramgallery::lang.plugin.description',
            'author' => 'Vladimir',
            'icon' => 'icon-instagram',
        ];
    }

    public function registerPermissions()
    {
        return [
            'pkurg.instagramgallery.manage_plugins' => [
                'tab' => 'pkurg.instagramgallery::lang.plugin.name',
                'label' => 'pkurg.instagramgallery::lang.plugin.permissionlabel'],
        ];
    }

    public function registerSettings()
    {
        return [
            'config' => [
                'label' => 'Instagram Gallery',
                'icon' => 'oc-icon-instagram',
                'description' => 'Set the authentication data',
                'class' => 'Pkurg\InstagramGallery\Models\Settings',
                'permissions' => ['pkurg.instagramgallery.manage_plugins'],
                'order' => 600,
            ],
        ];
    }

}
