<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
require_once __DIR__ . '/../../functions/definitions.php';

class NewsStoryRepeater extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'News Story Repeater';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Showcase the news or stories.';

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
  public $mode = 'preview';

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
    'post_type'     => 'post',
    'headline' => 'This is a headline',
    'cards_count'   => false,
  ];

  public function with()
  {
    $post_type = get_field('post_type');
    $cards = getCards($post_type);
    
    if (get_field('color') == 'white') {
      $card_color = get_field('card_color');
    } else {
      $card_color = 'dark';
    }
    
    return [
      'background'           => get_field('color') ?: $this->example['background'],
      'headline'             => get_field('headline') ?: $this->example['headline'],
      'subhead'              => get_field('subhead'),
      'is_folder_tab'        => true,
      'cards'                => $cards,
      'taxonomy_slug'        => $post_type == 'post' ? 'category' : $post_type . '_category',
      'cards_count'          => count($cards),
      'post_type'            => $post_type ?: $this->example['post_type'],
      'card_color'           => $card_color,
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
    $news_story_repeater = new FieldsBuilder('news_story_repeater', [
      'label_placement' => 'left',
    ]);

    $news_story_repeater
      ->addSelect('color', COLOR_SELECT)
      ->addText('headline', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 250,
        'default_value' => 'Story archive'
      ])
      ->addText('subhead', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 800,
        'default_value' => 'Use the filters to find the story you’re looking for.'
      ])
      ->addRadio('post_type', [
        'wpml_cf_preferences' => 1,
        'label'    => "What type of content?",
        'required' => 1,
         'choices'       => [
          'post'    => 'News',
          'story'   => 'Stories',
        ],
        'default_value' => 'post',
        'return_format' => 'value',
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
        ->and('post_type', '==', 'post')
    ;

    return $news_story_repeater->build();
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
