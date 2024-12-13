<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
require_once __DIR__ . '/../../functions/definitions.php';

class Cases extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Cases';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = '4th Circuit Cases.';

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
  public $icon = 'dashicons-portfolio';

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
    'headline' => 'This is a headline',
    'cards_count'   => false,
    'disclaimers'   => '',
  ];

  public function with()
  {
    $post_type = get_field('post_type');
    // $cards = getCards('case', 'date is_published');
    $cards = getCards('case', ['date' => 'DESC', 'is_published' => 'DESC']);
    
    return [
      'background'           => get_field('color') ?: $this->example['background'],
      'headline'             => get_field('headline'),
      'subhead'              => get_field('subhead'),
      'disclaimers'          => get_field('disclaimers') ?: "",
      'no_results'           => get_field('no_results') ?: "",
      'is_folder_tab'        => false,
      'cards'                => $cards,
      'cards_count'          => count($cards),
      'card_color'           => 'dark',
      'folder_tab'           => false,
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $fourth_circuit_cases = new FieldsBuilder('fourth_circuit_cases', [
      'label_placement' => 'left',
    ]);

    $fourth_circuit_cases
      ->addSelect('color', COLOR_SELECT)
      ->addText('headline', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 250,
        'default_value' => 'Case search'
      ])
      ->addText('subhead', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 250,
        'default_value' => 'Use the filters to find the cases you’re looking for.'
      ])
      ->addTextArea('no_results', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 800,
        'default_value' => 'There are no results for your search. Try updating your filter selections.'
      ])
      ->addWysiwyg('disclaimers', [
          'wpml_cf_preferences' => 2,
        ]);

    return $fourth_circuit_cases->build();
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
