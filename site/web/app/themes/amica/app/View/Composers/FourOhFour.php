<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FourOhFour extends Composer {
    /**
     * List of views served by this composer.
     *
     * @var array
     */

    protected static $views = [
        '404',
    ];

    
    /**
     * The block preview example data.
     *
     * @var array
     */
    private $example = [
        'background_type' => 'color',
        'height'          => 'auto',
        'background'      => 'white',
        'eyebrow'         => 'Eyebrow',
        'headline'        => 'Headline',
        'subhead'         => 'Subhead type copy goes here.',
        'cta'             => [
        'url'    => '#',
        'title'  => 'Button action',
        'target' => '_self',
        ],
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with() {
        return [
            'background_type'  => get_field('background_type', 'four_oh_four') ?: $this->example['background_type'],
            'height'           => get_field('height', 'four_oh_four') ?: $this->example['height'],
            'image'            => get_field('background_type', 'four_oh_four') === 'image' ? get_field('image', 'four_oh_four') : false,
            'background'       => get_field('color', 'four_oh_four'),
            'eyebrow'          => get_field('eyebrow', 'four_oh_four'),
            'copy'             => get_field('copy', 'four_oh_four'),
            'headline'         => get_field('headline', 'four_oh_four'),
            'subhead'          => get_field('subhead', 'four_oh_four'),
            'cta'              => get_field('cta', 'four_oh_four'),
        ];
    }
}
