<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class CaseEntry extends Field
{
  /**
   * The field group.
   *
   * @return array
   */
  public function fields()
  {
      $person = new FieldsBuilder('case', [
        'position' => 'acf_after_title'
      ]);

      $person
          ->setLocation('post_type', '==', 'case');

      $person
        ->addDatePicker('date', [
          'required'            => true,
          'wpml_cf_preferences' => 1,
          'wrapper' => [
              'width' => '',
              'class' => 'max-w-300',
              'id' => '',
          ],
        ])
        ->addWysiwyg('description', [
          'wpml_cf_preferences' => 1,
        ])
        ->addTrueFalse('is_published', [
          'label' => 'Published',
          'wpml_cf_preferences' => 1,
          'wrapper' => [
              'width' => '',
              'class' => 'flex gap-2 flex-row-reverse justify-end',
              'id' => '',
          ],
        ])
        ->addLink('case_pdf', [
          'label' => 'Case PDF URL',
          'required' => 0,
      ]);

      ;
      return $person->build();
  }
}