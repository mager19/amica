<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
use App\Fields\Partials\FolderTab;
require_once __DIR__ . '/../../functions/definitions.php';

class OneColumnEmbed extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'One Column Embed';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Add embed code underneath the One Column module';

  /**
   * The block category.
   *
   * @var string
   */
  public $category = 'basic-content';

  /**
   * The block icon.
   *
   * @var string|array
   */
  public $icon =  '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
    <rect x="6" y="7" width="12" height="3" fill="black"/>
    <rect x="2" y="11" width="20" height="1" fill="black"/>
    <rect x="5" y="13" width="14" height="1" fill="black"/>
    <rect x="4" y="15" width="16" height="1" fill="black"/>
    <rect x="9" y="17" width="6" height="2" fill="black"/>
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
    'layout'     => 'left',
    'image'      => [ 'ID' => 1 ],
    'eyebrow'    => 'Eyebrow',
    'headline'   => 'Headline',
    'subhead'    => 'Subhead',
    'copy'       => 'Copy',
    'cta'        => [
      'url'    => '#',
      'title'  => 'Button Action',
      'target' => '_self',
    ],
    'background' => 'white',
  ];

  public function with()
  {
    return [
      'background'          => get_field('color') !== NULL ? get_field('color') : $this->example['background'],
      'headline'            => get_field('headline') !== NULL ? get_field('headline') : $this->example['headline'],
      'is_headline_hidden'  => get_field('is_headline_hidden') !== NULL ? get_field('is_headline_hidden') : false,
      'type'                => get_field('embed_type'),
      'code'                => get_field('embed_code'),
      'gravityforms'        => get_field('embed_gravityforms'),
      'folder_tab'          => get_field('folder_tab') !== NULL ? get_field('folder_tab') : false,
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $one_column_embed = new FieldsBuilder('one_column_embed');

    $one_column_embed
      ->addSelect('color', COLOR_SELECT)
      
      ->addFields($this->get(FolderTab::class))
      
      ->addText('headline', [
        'wpml_cf_preferences' => 2,
        'maxlength' => 250
      ])
      ->addTrueFalse('is_headline_hidden', [
          'label' => 'Hide the headline?',
          'default_value' => false,
          'ui'  => 1,
      ])
      ->addGroup('embed')
        ->addRadio('type', [
          'wpml_cf_preferences' => 1,
          'layout' => 'vertical',
          'choices' => [
            'gravityforms' => 'Gravity Forms',
            'code' => 'Embed Code',
            // 
          ],
          'default_value' => 'code',
        ])
        ->addField('gravityforms', 'forms')
          ->conditional('type', '==', 'gravityforms')
        ->addTextarea('code')
          ->conditional('type', '==', 'code')
      ->endGroup()
     
      ;

    return $one_column_embed->build();
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
