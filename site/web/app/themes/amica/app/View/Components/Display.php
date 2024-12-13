<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Display extends Component {
  public $html;
  public $size;
  public $component_class;


  private $base_class = 'display';

  public function __construct(
    $html = 'span',
    $size = 2,
  ) {
    $this->html = $html;
    $this->size = (!is_numeric($size) || $size <= 3 ) ? $size : 2;
    $this->component_class = $this->buildComponentClass();
  }

  public function buildComponentClass() {
    return implode(' ', [
      $this->base_class,
      'display-' . $this->size,
    ]);
  }

  public function render() {
    return $this->view('partials.typography');
  }
}
