<?php namespace Acte\Carousel\Components;

use Cms\Classes\ComponentBase;
use Acte\Carousel\Models\Carousel as CarouselModel;


class Carousel extends ComponentBase
{

  public function componentDetails()
  {
    return [
      'name' => 'Carousel',
      'description' => 'Display images in a carousel',
    ];
  }

  public function defineProperties()
  {
    return [
      'textWhite' => [
        'title' => 'Text white',
        'description' => '.white-text class',
        'type' => 'checkbox',
        'default' => 'false',
      ],
      'imageThumbMode' => [
        'title' => 'Thumb mode',
        'description' => '',
        'type' => 'dropdown',
        'default' => 'crop',
        'options'     => ['auto'=>'Auto', 'crop'=>'Crop'],
        'group' => 'Image Thumb',
      ],
      'imageThumbQuality' => [
        'title' => 'Thumb quality',
        'description' => 'Jpeg compression 0-100',
        'type' => 'dropdown',
        'default' => 80,
        'options' => [
          '10' => '10',
          '20' => '20',
          '30' => '30',
          '40' => '40',
          '50' => '50',
          '60' => '60',
          '70' => '70',
          '80' => '80',
          '85' => '85',
          '90' => '90',
          '95' => '95',
          '100' => '100',
        ],
        'group' => 'Image Thumb',
      ],
      'imageThumbWidth' => [
        'title' => 'Thumb width',
        'description' => '',
        'type' => 'string',
        'default' => 640,
        'validationPattern' => '^[0-9]+$',
        'validationMessage' => 'Must be a number.',
        'group' => 'Image Thumb'
      ],
      'imageThumbHeight' => [
        'title' => 'Thumb height',
        'description' => '',
        'type' => 'string',
        'default' => 400,
        'validationPattern' => '^[0-9]+$',
        'validationMessage' => 'Must be a number.',
        'group' => 'Image Thumb'
      ],
      'maskActivate' => [
        'title' => 'Activate mask',
        'description' => 'Apply color filter on carousel pictures',
        'type' => 'checkbox',
        'group' => 'Mask'
      ],
      'maskIntensity' => [
        'title' => 'Mask intensity',
        'description' => 'Adjust color intensity',
        'type' => 'dropdown',
        'default' => 'slight',
        'options'     => [
          'slight'=>'Slight',
          'light'=>'Light',
          'strong' => 'Strong'
          ],
        'group' => 'Mask',
      ],
      'maskColor' => [
        'title' => 'Mask color',
        'description' => 'Adjust color intensity',
        'type' => 'dropdown',
        'default' => 'black',
        'options' => [
          'blue' => 'blue',
          'red' => 'red',
          'pink' => 'pink',
          'purple' => 'purple',
          'indigo' => 'indigo',
          'cyan' => 'cyan',
          'teal' => 'teal',
          'green' => 'green',
          'lime' => 'lime',
          'yellow' => 'yellow',
          'orange' => 'orange',
          'brown' => 'brown',
          'grey' => 'grey',
          'blue-grey' => 'blue-grey',
          'black' => 'black',
          'stylish' => 'stylish',
          'white' => 'white',
        ],
        'group' => 'Mask',
      ],
      // 'maskPattern' => [
      //   'title' => 'Mask pattern',
      //   'description' => 'Choose mask pattern',
      //   'type' => 'dropdown',
      //   'default' => '',
      //   'options' => [
      //     '' => 'no pattern',
      //     'pattern-1' => '1',
      //     'pattern-2' => '2',
      //     'pattern-3' => '3',
      //     'pattern-4' => '4',
      //     'pattern-5' => '5',
      //     'pattern-6' => '6',
      //     'pattern-7' => '7',
      //     'pattern-8' => '8',
      //     'pattern-9' => '9',
      //   ],
      //   'group' => 'Mask',
      // ],
    ];
  }

  public function records(){

    return CarouselModel::default()->get();

  }



}
