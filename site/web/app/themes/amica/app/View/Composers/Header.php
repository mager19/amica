<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Header extends Composer {
  /**
   * List of views served by this composer.
   *
   * @var array
   */
  protected static $views = [
    'sections.header',
  ];

  private $header;

  /**
   * Data to be passed to view before rendering.
   *
   * @return array
   */
  public function with() {
    $this->header = get_field('header', 'option');
    $this->header['logo'] = get_theme_mod( "playground_logo" );

    return [
      'header'            => $this->header,
      // 'background_color'  => $this->getBackgroundColor(),
      'menu_class'            => $this->getMenuClass(),
      'nav_class'             => $this->getNavClass(),
      'secondary_menu_class'  => $this->getMenuClass('secondary'),
      'secondary_nav_class'   => $this->getNavClass('secondary'),
    ];
  }

  // public function getBackgroundColor() {
  //   // if($this->header['background_color'] == 'custom') return $this->header['background_color'];
  //   $theme_colors = get_field('theme_colors', 'option');
  //   return $theme_colors[$this->header['background_color']];
  // }

  public function getNavClass($type='primary') {
    // nav classes
    $nav_class = 'nav nav--'. $type . ' ';

    return $nav_class;
  }

  public function getMenuClass($type='primary') {
    // nav > ul classes
    $menu_class = 'menu menu--' . $type . ' ';

    return $menu_class;
  }
}
