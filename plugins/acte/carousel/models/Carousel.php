<?php namespace Acte\Carousel\Models;

use Model;

/**
 * Model
 */
class Carousel extends Model
{
  use \October\Rain\Database\Traits\Validation;
  use \October\Rain\Database\Traits\Sortable;

  public $timestamps = false;

  public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];
  public $translatable = ['title', 'lead', 'text', 'link_name'];

  public $rules = [
    'title' => 'nullable|string|max:64',
    'lead' => 'nullable|string|max:64',
    'text' => 'nullable|string|max:64',
    'img' => 'required',
    'link' => 'nullable|string|max:255',
    'link_name' => 'nullable|string|max:64',
  ];

  /** Relations **/
  public $attachOne = [
    'img' => ['System\Models\File', 'delete' => true],
  ];


  public $table = 'acte_carousel_carousel';


  public function scopeDefault($query){
    return $query->where('is_active', true)->orderBy('sort_order', 'asc');
  }


}
