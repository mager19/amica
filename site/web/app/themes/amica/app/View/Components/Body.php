<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Body extends Component {
  public $html;
  public $component_class;

  private $size;
  private $type;
  private $textColor;

  private $base_class = 'body';

  public function __construct(
    $size = '1',
    $type = null,
    $html = 'p',
  ) {
    $this->html = $html;
    $this->size = $size;
    $this->type = $type ? '-' . $type : '';
    $this->component_class = $this->buildComponentClass();
  }

  public function buildComponentClass() {
    return implode(' ', [
      $this->base_class . $this->type,
      'body' . $this->type . '-' .  $this->size,
    ]);
  }

  public function render() {
    return $this->view('partials.typography');
  }
}
