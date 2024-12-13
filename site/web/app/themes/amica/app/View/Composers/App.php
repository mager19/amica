<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer {
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    '*',
  ];

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with() {
    return [
      'nav_type'      => get_field('nav_type', 'ui'),
      'alert'         => get_field('show_alert') ? get_field('alert') : false,
      'siteName'      => $this->siteName(),
      'theme_colors'  => get_field('theme_colors', 'option'),
      'app'           => $this,
    ];
  }

  /**
   * Returns the site name.
   *
   * @return string
   */
  public function siteName() {
    return get_bloginfo('name', 'display');
  }

  public function truncateText($text=null, $length=50) {

    if (strlen($text) > $length) {
      // Truncate the text and add an ellipsis
      $text = substr($text, 0, $length) . '&#8230;';
    }

    return $text;
  }
}
