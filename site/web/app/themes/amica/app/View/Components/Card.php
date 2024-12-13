<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class Card extends Component
{
    
    public $eyebrow;
    public $headline;
    public $card_headline;
    public $headingLevel;
    public $subhead;
    public $card_subhead;
    public $copy;
    public $image;
    public $cta;
    public $cta_type;
    public $cta_icon;
    public $html;
    public $imageBg;
    public $is_folder_tab;
    public $card_color;
    public $total_cards;
    public $subhead_el;
    public $padding;
    public $repeater;

    public $component_class;

    public function __construct(
        $eyebrow        = null,
        $headline       = null,
        $cardHeadline   = null,
        $subhead        = null,
        $cardSubhead    = null,
        $copy           = null,
        $image          = null,
        $cta            = null,
        $ctaType        = null,
        $ctaIcon        = null,
        $imageBg        = false,
        $isFolderTab    = false,
        $cardColor      = false,
        $html           = 'div',
        $totalCards     = 1,
        $subheadEl      = 'p',
        $padding        = 'inner',
        $repeater       = false,
        $headingLevel   = 'p',
    )
    {
        $this->eyebrow          = $eyebrow;
        $this->headline         = $headline;
        $this->card_headline    = $cardHeadline;
        $this->headingLevel     = $headingLevel;
        $this->subhead          = $subhead;
        $this->card_subhead     = $cardSubhead;
        $this->copy             = $copy;
        $this->image            = $image;
        $this->cta              = $cta;
        $this->cta_type         = $ctaType;
        $this->cta_icon         = $ctaIcon;
        $this->html             = $html;
        $this->imageBg          = $imageBg;
        $this->is_folder_tab    = $isFolderTab;
        $this->card_color       = $cardColor;
        $this->padding          = $padding;
        $this->repeater         = $repeater;
        $this->total_cards      = $totalCards;
        $this->subhead_el       = $subheadEl;
        $this->component_class  = $this->buildComponentClass();
    }


    public function buildComponentClass() {
        return implode(' ', [
            'component--card',
        ]);
      }

    public function render()
    {
        return view('components.card');
    }
}
