<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use WP_Query;

class PersonEntry extends Field
{
  /**
   * The field group.
   *
   * @return array
   */
  public function fields()
  {
      $person = new FieldsBuilder('person');

      $person
          ->setLocation('post_type', '==', 'person');

      $person
        ->addTrueFalse('is_person', [
          'label' => 'Person or partner?',
          'default_value' => true,
          'ui'  => 1,
          'ui_on_text' => 'Person',
          'ui_off_text' => 'Partner',
        ])
        ->addText('first', [
          'label'               => 'First Name',
          'required'            => true,
          'wpml_cf_preferences' => 0,
          'conditional_logic' => [[
            'field' => 'is_person',
            'operator' => '==',
            'value' => 1
          ]],
        ])
        ->addText('last', [
          'label'               => 'Last Name',
          'required'            => true,
          'wpml_cf_preferences' => 0,
          'conditional_logic' => [[
            'field' => 'is_person',
            'operator' => '==',
            'value' => 1
          ]],
        ])
        ->addText('title', [
          'required'            => false,
          'wpml_cf_preferences' => 2,
          'conditional_logic' => [[
            'field' => 'is_person',
            'operator' => '==',
            'value' => 1
          ]],
        ])
        ->addText('program', [
          'wpml_cf_preferences' => 2,
          'label' => 'Program, Department, or Organization',
        ])
        ->addEmail('email', [
          'wpml_cf_preferences' => 0,
          'conditional_logic' => [[
            'field' => 'is_person',
            'operator' => '==',
            'value' => 1
          ]],
        ])
        ->addImage('partner_logo', [
          'wpml_cf_preferences' => 0,
          'mime_types' => 'svg,png',
          'conditional_logic' => [[
            'field' => 'is_person',
            'operator' => '!=',
            'value' => 1
          ]],
        ])
        ;
      return $person->build();
  }
}