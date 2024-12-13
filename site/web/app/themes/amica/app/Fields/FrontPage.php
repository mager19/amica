<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

use App\Fields\Partials\AlertBar;

class FrontPage extends Field {
  /**
   * The field group.
   *
   * @return array
   */
  public function fields() {
    $frontPage = new FieldsBuilder('front_page');

    $frontPage
      ->setLocation('page_type', '==', 'front_page');

    $frontPage
      ->addFields($this->get(AlertBar::class));
      
    return $frontPage->build();
  }
}
