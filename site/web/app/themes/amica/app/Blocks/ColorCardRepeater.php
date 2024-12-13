<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\FolderTab;
require_once __DIR__ . '/../../functions/definitions.php';

class ColorCardRepeater extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Color Card Repeater';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Unlimited amount of items, displayed as cards on a colored background.';

  /**
   * The block category.
   *
   * @var string
   */
  public $category = 'action-modules';

  /**
   * The block icon.
   *
   * @var string|array
   */
  public $icon = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
    <rect x="13" y="3" width="8" height="12" fill="black"/>
    <rect x="3" y="3" width="8" height="12" fill="black"/>
    <rect x="14" y="7" width="6" height="1" fill="white"/>
    <rect x="4" y="7" width="6" height="1" fill="white"/>
    <rect x="14" y="9" width="6" height="1" fill="white"/>
    <rect x="4" y="9" width="6" height="1" fill="white"/>
    <rect x="14" y="11" width="6" height="1" fill="white"/>
    <rect x="14" y="13" width="3" height="1" fill="white"/>
    <rect x="4" y="11" width="6" height="1" fill="white"/>
    <rect x="4" y="13" width="3" height="1" fill="white"/>
    <rect x="14" y="4" width="6" height="2" fill="white"/>
    <rect x="4" y="4" width="6" height="2" fill="white"/>
    <rect x="16" y="21" width="1" height="1" fill="black"/>
    <rect x="16" y="19" width="1" height="1" fill="black"/>
    <rect x="16" y="17" width="1" height="1" fill="black"/>
    <rect x="18" y="19" width="1" height="1" fill="black"/>
    <rect x="18" y="17" width="1" height="1" fill="black"/>
    <rect x="20" y="19" width="1" height="1" fill="black"/>
    <rect x="20" y="17" width="1" height="1" fill="black"/>
    <rect x="20" y="21" width="1" height="1" fill="black"/>
    <rect x="18" y="21" width="1" height="1" fill="black"/>
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
    'align' => true,
    'align_text' => false,
    'align_content' => false,
    'full_height' => false,
    'anchor' => false,
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
    'background'    => false,
    'headline'      => 'Color Card Headline',
    'cards'         => [
      'eyebrow'     => 'Eyebrow',
      'headline'    => 'Headline',
      'cta'       => [
        'url'   => '#',
        'title' => 'Button action',
        'target' => '_self',
      ],
    ],
    'cards_count'   => false,
  ];

  public function with()
  {
    $cards = get_field('cards');
    return [
      'background'       => get_field('color') ?: $this->example['background'],
      'eyebrow'          => get_field('eyebrow'),
      'headline'         => get_field('headline') ?: null,
      'subhead'          => get_field('subhead'),
      'copy'             => get_field('copy'),
      'cta'              => get_field('cta'),
      'cards'            => $cards,
      'cards_count'      => is_array($cards) ? count($cards) : 0,
      'folder_tab'       => get_field('folder_tab') !== NULL ? get_field('folder_tab') : false,
      'is_headline_hidden'  => get_field('is_headline_hidden') !== NULL ? get_field('is_headline_hidden') : false,
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $color_card_repeater = new FieldsBuilder('color_card_repeater');

    $color_card_repeater
      ->addTab('content')
        ->addFields($this->get(Copy::class))
          ->modifyField('headline', ['required' => true])
        ->addTrueFalse('is_headline_hidden', [
          'label' => 'Hide the headline?',
          'default_value' => false,
          'ui'  => 1,
        ])
      ->addTab('cards')
        ->addRepeater('cards', [
          'wpml_cf_preferences' => 3,
          'collapsed' => 'headline',
          'layout' => 'row',
          'min' => 1,
        ])
          ->addFields($this->get(Copy::class))
          ->removeField('subhead')
        ->endRepeater()

      ->addTab('config')
        ->addSelect('color', COLOR_SELECT)
          ->modifyField('color', [
            'label' => 'Color Theme'
          ])
        ->addFields($this->get(FolderTab::class))
      ;

    return $color_card_repeater->build();
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
