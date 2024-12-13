<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Image extends Component
{
    public $id;
    public $size;
    public $class;
    public $align_y;
    public $align_x;
    public $caption_class;
    public $caption;

    public function __construct(
      $id    = null,
      $size  = 'content',
      $class = '',
      $alignY = 'right',
      $alignX = 'bottom',
      $captionClass = '',
    ) 
    {
      $this->id             = $id;
      $this->size           = $size;
      $this->class          = $class;
      $this->align_y        = $alignY == 'top' ? $alignY : 'bottom';
      $this->align_x        = $alignX == 'right' ? $alignX : 'left';
      $this->caption_class  = $captionClass;
      $this->caption        = wp_get_attachment_caption($id);
    }

    public function render() 
    {
      return view('components.image');
    }
}
