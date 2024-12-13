<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Search extends Composer {
  
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'partials.search',
  ];

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with() {  
    return [
      'typeahead' => true,
      'input_value' => isset($_GET['address']) ? htmlspecialchars_decode(sanitize_text_field($_GET['address'])) : '',
    ];
  }
  
}