<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Button extends Component {
  public $html;
  public $component_class;
  public $color;
  public $size;
  public $type;
  public $icon;

  private $base_class = 'button';

  private $types = [
    'link',
    'border',
  ];

  /** 
   * html: [optional] a (default) or button
   * type: [optional] button (default) or link
   * color: [optional] BrandColors
   * icon: [optional]
   */
  public function __construct(
    $html = 'a',
    $type = '',
    $color = false,
    $size = false,
    $icon = false
  ) {
    $this->color = $color;
    $this->html = $html;
    $this->icon = $icon;
    $this->size = $size;
    $this->type = $type;
    $this->component_class = $this->buildComponentClass();
  }

  public function buildComponentClass() {
    return implode(' ', [
      $this->type !== 'link' ? $this->base_class : '',
      in_array($this->type, $this->types) ? 'button-' . $this->type : '',
      $this->icon ? 'button-icon' : '',
      $this->size === 'small' ? 'button-small' : '',
      $this->color ? 'button-' . $this->color : '',
    ]);
  }

  public function render() {
    return $this->view('partials.typography');
  }
}


