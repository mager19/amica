<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

require_once __DIR__ . '/../../../functions/definitions.php';

class AlertBar extends Partial {
  /**
   * The partial field group.
   *
   * @return array
   */
  public function fields() {
    $alert = new FieldsBuilder('alert');

    $alert
      ->addTrueFalse('show_alert', [
        'ui' => 1,
        'wpml_cf_preferences' => 1,
      ])
      ->addSelect('alert_color', COLOR_SELECT)
      ->addGroup('alert', [
        'wpml_cf_preferences' => 3,
        'conditional_logic' => [
          [
            'field'     => 'show_alert',
            'operator'  => '==',
            'value'     => 1,
          ]
        ]
      ])
        ->addTextarea('text', [
          'wpml_cf_preferences' => 2,
          'required'      => true,
          'instructions'  => 'Max. characters of 120',
          'maxlength'     => 120,
          'rows'          => 2,
        ])
        ->addTextarea('subtext', [
          'wpml_cf_preferences' => 2,
          'instructions'  => 'Max. characters of 650',
          'maxlength'     => 650,
          'rows'          => 5,
        ])
        ->addLink('cta', [
          'wpml_cf_preferences' => 2,
          'label' => 'Call to Action',
        ])
      ->endGroup();

    return $alert;
  }
}
