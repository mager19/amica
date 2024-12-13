<?php

namespace App\Options;

use Log1x\AcfComposer\Options as Field;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\CTAFull;

class FourOhFour extends Field {
  public $name = '404 Page';
  public $parent = 'site-options';
  public $title = '404 Page | Site Options';
  public $redirect = false;
  public $description = '404 page values';  
  public $capability = 'edit_posts';
  public $post = 'four_oh_four';

  /**
   * The option page field group.
   *
   * @return array
   */
  public function fields() {
    $four_oh_four_options = new FieldsBuilder('four_oh_four_options', ['title' => '404 Page Fields']);

    $four_oh_four_options
      ->addFields($this->get(CTAFull::class))
        ->modifyField('headline', [
          'default_value' => '404 Error'
        ])
      ;

      return $four_oh_four_options->build();
  }
}
