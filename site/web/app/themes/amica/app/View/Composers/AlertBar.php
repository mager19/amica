<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class AlertBar extends Composer {
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'partials.alert-bar',
  ];

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with() {
    return [
      'use'        => 'bar',
      'alert'      => get_field('alert'),
      'background' => get_field('alert_color'),
      'text'       => get_field('alert_text'),
      'subtext'       => get_field('alert_subtext'),
      'cta'        => get_field('alert_cta'),
    ];
  }
}
