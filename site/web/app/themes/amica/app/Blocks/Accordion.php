<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\ShowNumbers;
require_once __DIR__ . '/../../functions/definitions.php';

class Accordion extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Accordion';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Add a list of content nested in accordions';

    /**
     * The block category.
     *
     * @var string
     */
    public $category = 'interactive-content';

    /**
     * The block icon.
     *
     * @var string|array
     */
    public $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
      <rect x="2" y="4" width="20" height="1" fill="black"/>
      <rect x="2" y="2" width="20" height="1" fill="black"/>
      <rect x="4" y="8" width="12" height="2" fill="black"/>
      <rect x="4" y="11" width="12" height="1" fill="black"/>
      <rect x="18" y="8" width="1" height="1" fill="black"/>
      <rect x="19" y="7" width="1" height="1" fill="black"/>
      <rect x="20" y="6" width="1" height="1" fill="black"/>
      <rect x="20" y="8" width="1" height="1" fill="black"/>
      <rect x="18" y="6" width="1" height="1" fill="black"/>
      <rect x="2" y="21" width="20" height="1" fill="black"/>
      <rect x="2" y="19" width="20" height="1" fill="black"/>
      <rect x="4" y="13" width="12" height="1" fill="black"/>
      <rect x="4" y="15" width="12" height="1" fill="black"/>
      <rect x="0.5" y="0.5" width="23" height="23" fill="none" stroke="black"/>
    </svg>';

    /**
     * The block keywords.
     *
     * @var array
     */
    public $keywords = [];

    /**
     * The block post type allow list.
     *
     * @var array
     */
    public $post_types = ['page'];

    /**
     * The parent block type allow list.
     *
     * @var array
     */
    public $parent = [];

    /**
     * The default block mode.
     *
     * @var string
     */
    public $mode = 'auto';

    /**
     * The default block alignment.
     *
     * @var string
     */
    public $align = '';

    /**
     * The default block text alignment.
     *
     * @var string
     */
    public $align_text = '';

    /**
     * The default block content alignment.
     *
     * @var string
     */
    public $align_content = '';

    /**
     * The supported block features.
     *
     * @var array
     */
    public $supports = [
        'align' => false,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => true,
        'mode' => false,
        'multiple' => true,
        'jsx' => true,
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = [];

    /**
     * The block preview example data.
     *
     * @var array
     */
    public $example = [
      'color'    => 'white',
      'eyebrow'  => 'Eyebrow content',
      'headline' => 'This is a headline',
      'subhead'  => 'A sub head is a strong',
      'copy'     => 'Lorem ipsum dolor sit amet consectetur. Ut tempus sit quam pellentesque justo viverra.',
      'cta'      => [
        'url'   => '#',
        'title' => 'Button action',
        'target' => '_self',
      ],
      'panels'   => [
        [
          'headline' => 'This is a headline',
          'subhead'  => false,
          'copy'     => 'Lorem ipsum dolor sit amet consectetur. Ut tempus sit quam pellentesque justo viverra.',
          'cta'      => [],
          'image'    => false
        ]
      ],
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
          'background'  => get_field('color') ?: $this->example['color'],
          'left_background'  => $this->get_background_for_half('left'),
          'right_background' => $this->get_background_for_half('right'),
          'eyebrow'     => get_field('eyebrow'),
          'headline'    => get_field('headline'),
          'subhead'     => get_field('subhead'),
          'copy'        => get_field('copy'),
          'cta'         => get_field('cta'),
          'two_cols'    => get_field('two_cols'),
          'show_numbers'=> get_field('show_numbers'),
          'panels'      => ( get_field('panels') && count(get_field('panels')) !== 0 ) ? get_field('panels') : $this->example['panels'],
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $accordion = new FieldsBuilder('accordion');

        $accordion
          ->addTab('content')
            ->addFields($this->get(Copy::class))
          ->addTab('panels')
            ->addRepeater('panels', [
              'wpml_cf_preferences' => 3,
              'layout'    => 'row',
              'collapsed' => 'headline',
              'min'       => 2,
              'button_label' => 'Add Another Panel',
            ])
              ->addFields($this->get(Copy::class))
                ->removeField('eyebrow')
              ->addImage('image', [
                'wpml_cf_preferences' => 3,
                'mime_type' => 'jpg, webp',
                'instructions'  => 'Upload JPG or WebP images at 1200 pixels wide.',
                'preview_size' => 'thumbnail',
              ])
            ->endRepeater()
          ->addTab('config')
            ->addSelect('color', COLOR_SELECT)
            ->addTrueFalse('two_cols', [
              'wpml_cf_preferences' => 1,
              'label' => 'Two column layout?',
              'ui' => 1,
              'default_value' => 0
            ])
            ->addFields($this->get(ShowNumbers::class))
          ;

        return $accordion->build();
    }

    private function get_background_for_half($direction = 'left') {
      return 'left' === $direction ? 'var-background' : 'var-background-light';
    }

    /**
     * Assets to be enqueued when rendering the block.
     *
     * @return void
     */
    public function enqueue()
    {
        //
    }
}
