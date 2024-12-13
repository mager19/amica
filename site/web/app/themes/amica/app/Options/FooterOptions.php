<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class FooterOptions extends Field {
  public $name = 'Footer';
  public $parent = 'site-options';
  public $title = 'Footer | Site Options';
  public $redirect = false;
  public $description = 'Footer Description';
  public $capability = 'edit_posts';
  public $post = 'footer';
  
  /**
   * The option page field group.
   *
   * @return array
   */
  public function fields() {
    $footer_options = new FieldsBuilder('footer_options');

    $footer_options
      ->addGroup('legal', [
          'wpml_cf_preferences' => 3,
          'layout'    => 'row'
      ])
        ->addText('tax_info', [
            'wpml_cf_preferences' => 2,
            'label' => "Organization's tax status statement",
            'default_value' => 'Amica Center is a 501(c)(3) nonprofit organization. Tax EIN: 52-2141497',
        ])
        ->addText('copyright', [
            'wpml_cf_preferences' => 2,
            'label' => "Organization's legal name",
            'default_value' => 'Client Org.',
            'instructions'  => 'Copyright symbol (©) and current year are auto generated.'
        ])
      ->endGroup()

      ->addGroup('contact', [
          'wpml_cf_preferences' => 3,
          'layout'    => 'row',
      ])
        ->addRepeater('addresses', [
            'wpml_cf_preferences' => 3,
            'min' => 1
        ])
          ->addGroup('address', [
            'wpml_cf_preferences' => 3,
            'required' => true
          ])
            ->addText('street_line_1', [
              'wpml_cf_preferences' => 1,
              'required' => true
            ])
            ->addText('street_line_2', [
              'wpml_cf_preferences' => 1,
            ])
            ->addText('city', [
              'wpml_cf_preferences' => 1,
              'required' => true
            ])
            ->addText('state', [
              'wpml_cf_preferences' => 1,
              'required' => true
            ])
            ->addText('postal_code', [
              'wpml_cf_preferences' => 1,
              'required' => true
            ])
          ->endGroup()
        ->endRepeater()
      ->endGroup()
      ->addGroup('validation', [
          'label' => "Validation Logos",
          'wpml_cf_preferences' => 3,
          'layout'    => 'row'
      ])
        ->addRepeater('logos', [
            'wpml_cf_preferences' => 3,
        ])
          ->addLink('organization', [
            'wpml_cf_preferences' => 1,
            'required' => true
          ])
          ->addImage('icon', [
            'wpml_cf_preferences' => 1,
            'required' => true,
          ])
        ->endRepeater()
      ->endGroup();
      
    return $footer_options->build();
  }
}
