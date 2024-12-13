<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../../functions/definitions.php';

class TwoColumns extends Partial
{
  /**
   * The partial field group.
   *
   * @return array
   */
  public function fields()
  {
    $two_columns = new FieldsBuilder('two_columns');

    $two_columns
      ->addRadio('layout', [
        'wpml_cf_preferences' => 1,
        'label' => 'Text Position',
        'layout' => 'horizontal',
        'choices' => [
          'left' => 'Left',
          'right' => 'Right',
        ]
      ])
      ->addSelect('background', COLOR_SELECT)
      ->addGroup('text', [
        'wpml_cf_preferences' => 3,
      ])
        ->addFields($this->get(Copy::class))
      ->endGroup()
      ->addGroup('media', [
        'wpml_cf_preferences' => 3,
      ])
        ->addImage('image', [
          'wpml_cf_preferences' => 3,
          'mime_type' => 'jpg, webp',
          'preview_size'  => 'thumbnail',
          'instructions'  => 'Upload JPG or WebP images at 1280x1570.',
        ])
      ->endGroup();

    return $two_columns;
  }
}
