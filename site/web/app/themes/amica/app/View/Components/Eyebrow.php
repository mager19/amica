<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Eyebrow extends Component {
  public $html;
  public $type;
  public $component_class;


  private $base_class = 'eyebrow';


  public function __construct(
    $html = 'span',
  ) {
    $this->html = $html;
    $this->component_class = $this->buildComponentClass();
  }

  public function buildComponentClass() {
    return implode(' ', [
      $this->base_class,
    ]);
  }

  public function render() {
    return $this->view('partials.typography');
  }
}
