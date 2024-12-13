<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class CardSlider extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Card Slider';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Card Slider block.';

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
    <rect x="2" y="3" width="6" height="5" fill="black"/>
    <rect x="9" y="3" width="6" height="5" fill="black"/>
    <rect x="16" y="3" width="6" height="5" fill="black"/>
    <rect x="2" y="9" width="6" height="1" fill="black"/>
    <rect x="9" y="9" width="6" height="1" fill="black"/>
    <rect x="16" y="9" width="6" height="1" fill="black"/>
    <rect x="2" y="11" width="6" height="1" fill="black"/>
    <rect x="9" y="11" width="6" height="1" fill="black"/>
    <rect x="16" y="11" width="6" height="1" fill="black"/>
    <rect x="2" y="13" width="6" height="1" fill="black"/>
    <rect x="9" y="13" width="6" height="1" fill="black"/>
    <rect x="16" y="13" width="6" height="1" fill="black"/>
    <rect x="2" y="15" width="3" height="2" fill="black"/>
    <rect x="9" y="15" width="3" height="2" fill="black"/>
    <rect x="16" y="15" width="3" height="2" fill="black"/>
    <rect x="15" y="20" width="1" height="1" fill="black"/>
    <rect x="21" y="20" width="1" height="1" fill="black"/>
    <rect x="16" y="19" width="1" height="1" fill="black"/>
    <rect x="20" y="19" width="1" height="1" fill="black"/>
    <rect x="16" y="21" width="1" height="1" fill="black"/>
    <rect x="20" y="21" width="1" height="1" fill="black"/>
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
      'color'       => 'white',
      'cards' => [
        [
          'image' => null,
          'headline' => 'This is a headline'
        ]
      ],
      'headline' => 'This is a headline',
  ];

  public function with()
  {
      return [
          'background'     => get_field('color') ?: $this->example['color'],
          'cards'          => get_field('cards') ?: $this->example['cards'],
          'eyebrow'        => get_field('eyebrow'),
          'headline'       => get_field('headline'),
          'subhead'        => get_field('subhead'),
          'copy'           => get_field('copy'),
          'cta'            => get_field('cta'),
      ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $card_slider = new FieldsBuilder('card_slider');

    $card_slider
      ->addTab('content')
        ->addSelect('color', COLOR_SELECT)
        ->addFields($this->get(Copy::class))

      ->addTab('cards')
        ->addRepeater('cards', [
          'min' => 3,
          'label' => 'Cards',
          'layout' => 'row',
        ])
          ->addImage('image', [
            'wpml_cf_preferences' => 3,
            'instructions'  => 'Upload JPG or WebP images at 8x5.',
            'preview_size' => 'thumbnail',
          ])
          ->addFields($this->get(Copy::class))
            ->removeField('eyebrow')
        ->endRepeater()
    ;

    return $card_slider->build();
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
