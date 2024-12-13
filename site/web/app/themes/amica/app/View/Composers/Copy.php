<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Copy extends Composer {
  
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'partials.copy',
  ];

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with() {
    return [
      'mb' =>  isset($mb) ? $mb : '0',
      'align' =>  isset($align) ? $align : 'left',
      'repeater' =>  isset($repeater) ? $repeater : false,
      'class' =>  isset($class) ? $class : '',
      'padding' =>  isset($padding) ? $padding : 'inner',
      'copy_size' =>  isset($copy_size) ? $copy_size : 1,
    ];
  }
}