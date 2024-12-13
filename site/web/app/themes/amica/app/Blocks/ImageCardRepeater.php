<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class ImageCardRepeater extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Image Card Repeater';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Unlimited amount of items, displayed as cards on an image background.';

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
    <rect x="13" y="3" width="8" height="13" fill="black"/>
    <rect x="16" y="18" width="5" height="3" fill="black"/>
    <rect x="3" y="3" width="8" height="13" fill="black"/>
    <rect x="14" y="12" width="6" height="1" fill="white"/>
    <rect x="4" y="12" width="6" height="1" fill="white"/>
    <rect x="14" y="14" width="6" height="1" fill="white"/>
    <rect x="4" y="14" width="6" height="1" fill="white"/>
    <rect x="18" y="19" width="1" height="1" fill="white"/>
    <rect x="19" y="17" width="1" height="1" fill="black"/>
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
    'headline' => 'This is a headline',
    'cards'         => [
      'eyebrow'     => 'Eyebrow content',
      'headline'    => 'This is a headline',
      'cta'       => [
        'url'   => '#',
        'title' => 'Button action',
        'target' => '_self',
      ],
      'image'     => [ 
        'ID'  => 1,
        'url' => '/app/uploads/2023/09/image.png'
      ],
    ],
    'cards_count'   => false,
  ];

  public function with()
  {
    $cards = get_field('cards') ?: null;
    $custom_card_color = get_field('is_folder_tab') && get_field('color') == 'white';
    return [
      'background'           => get_field('color') ?: $this->example['background'],
      'eyebrow'              => get_field('eyebrow'),
      'headline'             => get_field('headline') ?: null,
      'subhead'              => get_field('subhead'),
      'copy'                 => get_field('copy'),
      'cta'                  => get_field('cta'),
      'is_folder_tab'        => get_field('is_folder_tab'),
      'cards'                => $cards,
      'card_color'           => $custom_card_color ? get_field('card_color') : false,
      'cards_count'          => is_array($cards) ? count($cards) : 0,
      'folder_tab'           => get_field('folder_tab') !== NULL ? get_field('folder_tab') : false,
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $image_card_repeater = new FieldsBuilder('image_card_repeater', [
      'label_placement' => 'left',
    ]);

    $image_card_repeater
      ->addTab('content')
        ->addFields($this->get(Copy::class))
        ->addTrueFalse('folder_tab', [
          'label' => 'Display tab?',
          'ui'  => 1,
        ])

      ->addTab('cards')
        ->addRepeater('cards', [
          'wpml_cf_preferences' => 3,
          'collapsed' => 'headline',
          'layout' => 'row',
          'min' => 2,
        ])
          ->addImage('image', [
            'wpml_cf_preferences' => 3,
            'mime_type' => 'jpg, webp',
            'preview_size'  => 'thumbnail',
            'instructions'  => 'Upload JPG or WebP images at 8x5.',
          ])
          ->addFields($this->get(Copy::class))
          ->removeField('subhead')
        ->endRepeater()

      ->addTab('config')
        ->addSelect('color', COLOR_SELECT)
        ->addTrueFalse('is_folder_tab', [
          'wpml_cf_preferences' => 1,
          'label' => 'Use the folder tab design?',
          'instructions'  => '<p>If set to "yes", the card text will have a golden background and have the "Amica" folder tab above it.</p><p>If set to "no", the card text will have high-contrast background without the tab.</p>',
          'ui' => 1,
        ])
        ->addSelect('card_color', [
          'wpml_cf_preferences' => 1,
          'choices'       => [
              'dark'    => 'Dark',
              'bedrock' => 'Bedrock',
              'golden'  => 'Golden',
              'verdant' => 'Verdant',
          ],
          'default_value' => 'dark',
          'return_format' => 'value',
        ])
          ->conditional('color', '==', 'white')
            ->and('is_folder_tab', '==', 1)
      ;

    return $image_card_repeater->build();
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
