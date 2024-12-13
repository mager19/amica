<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../../functions/definitions.php';

class CTAFull extends Partial
{
  /**
   * The partial field group.
   *
   * @return array
   */
  public function fields()
  {
    $c_t_a_full = new FieldsBuilder('c_t_a_full');

    $c_t_a_full
      ->addRadio('background_type', [
        'wpml_cf_preferences' => 1,
        'layout'  => 'horizontal',
        'choices' => [
          'color' => 'Color',
          'image' => 'Image',
          'video' => 'Video',
        ]
      ])
      ->addRadio('height', [
        'wpml_cf_preferences' => 1,
        'layout'  => 'horizontal',
        'default_value' => 'screen',
        'choices' => [
          'screen' => 'Screen',
          'auto' => 'Auto',
        ]
      ])
      ->addSelect('color', COLOR_SELECT)
        ->modifyField('color', [
            'label' => 'Color Theme',
            'conditional_logic' => [[
              'field' => 'background_type',
              'operator' => '!=',
              'value' => 'image'
            ]]
        ])
      ->addImage('image', [
        'wpml_cf_preferences' => 3,
        'required' => true,
        'mime_type' => 'jpg, webp',
        'instructions'  => 'Upload JPG or WebP images at 2880x2400.',
        'preview_size' => 'thumbnail',
      ])
        ->conditional('background_type', '==', 'image')
      ->addOembed('video', [
        'wpml_cf_preferences' => 2,
      ])
        ->conditional('background_type', '==', 'video')
      ->addFields($this->get(Copy::class))
    ;

    return $c_t_a_full;
  }
}
