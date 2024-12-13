<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class UserInterface extends Field {
  public $name = 'User Interface';
  public $parent = 'site-options';
  public $title = 'User Interface | Site Options';
  public $redirect = false;
  public $description = 'Customize frontend look & feel.';
  public $capability = 'edit_theme_options';
  public $post = 'ui';

  /**
   * The option page field group.
   *
   * @return array
   */
  public function fields() {
    $user_interface = new FieldsBuilder('user_interface');

    $user_interface
      ->addSelect('nav_type', [
        'instructions' => '
          <dl>
            <dt><strong>Relative</strong></dt>
            <dd>Stays on the top of the page.</dd>
            <dt><strong>Shy</strong></dt>
            <dd>Hides when scrolling down, pops back up when user scrolls up.</dd>
            <dt><strong>Fixed</strong></dt>
            <dd>Stays at the top of the page.</dd>
          </dl>',
        'choices' => [
          'relative' => 'Relative',
          'shy'      => 'Shy',
          'fixed'    => 'Fixed',
        ],
        'default_value' => 'shy',
      ]);


    return $user_interface->build();
  }
}
