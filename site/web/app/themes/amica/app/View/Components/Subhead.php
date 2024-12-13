<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Subhead extends Component {
  public $html;
  public $component_class;


  private $base_class = 'subhead';

  public function __construct(
    $html = 'h3',
    $size = 1

  ) {
    $this->html = $html;
    $this->size = is_numeric($size) && $size < 5 ? $size : 1;
    $this->component_class = $this->buildComponentClass();
  }

  public function buildComponentClass() {
    return implode(' ', [
      $this->base_class,
      'subhead-' . $this->size,
    ]);
  }

  public function render() {
    return $this->view('partials.typography');
  }
}
