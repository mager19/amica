<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Footer extends Composer {
  
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'sections.footer',
  ];

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with() {
    return [
      'socials'            => get_field('socials', 'brand'),
      'tax_info'           => get_field('legal_tax_info', 'footer'),
      'copyright'          => get_field('legal_copyright', 'footer'),
      'addresses'          => get_field('contact_addresses', 'footer') ?: [],
      'validation_logos'   => get_field('validation_logos', 'footer') ?: [],
    ];
  }
}