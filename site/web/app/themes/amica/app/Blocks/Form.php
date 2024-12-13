<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class Form extends Block
{
  /**
   * The block name.
   *
   * @var string
   */
  public $name = 'Form';

  /**
   * The block description.
   *
   * @var string
   */
  public $description = 'Use this to add a form.';

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
    <rect x="0.5" y="0.5" width="23" height="23" stroke="black"/>
    <rect x="0.5" y="0.5" width="23" height="23" fill="white"/>
    <rect x="6" y="4" width="12" height="16" fill="black"/>
    <rect x="8" y="13" width="8" height="1" fill="white"/>
    <rect x="8" y="11" width="8" height="1" fill="white"/>
    <rect x="8" y="9" width="8" height="1" fill="white"/>
    <rect x="10" y="6" width="4" height="1" fill="white"/>
    <rect x="9" y="16" width="6" height="2" fill="white"/>
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
    'background'    => 'white',
    'headline' => 'This is a headline',
  ];

  public function with()
  {
    $is_embed = get_field('form_type') == 'embed';
    return [
      'folder_tab'           => get_field('folder_tab'),
      'is_image_background'  => get_field('is_image_background'),
      'image'                => get_field('image'),
      'background'           => get_field('color') ?: $this->example['background'],
      'eyebrow'              => get_field('eyebrow'),
      'headline'             => get_field('headline') ?: $this->example['headline'],
      'subhead'              => get_field('subhead'),
      'copy'                 => get_field('copy'),
      'cta'                  => get_field('cta'),
      'form_embed'           => get_field('form_embed'),
      'form_gravityforms'    => get_field('form_gravityforms'),
      'form_headline'        => $is_embed ? null : get_field('form_headline'),
      'form_copy'            => $is_embed ? null : get_field('form_copy'),
    ];
  }

  /**
   * The block field group.
   *
   * @return array
   */
  public function fields()
  {
    $form = new FieldsBuilder('form', [
      'label_placement' => 'left',
    ]);

    $form
      ->addTrueFalse('folder_tab', [
        'label' => 'Display tab?',
        'ui'  => 1,
      ])
      ->addTrueFalse('is_image_background', [
        'label' => 'Is there an image in the background?',
        'ui' => 1,
        'default_value' => 0,
      ])
      ->addImage('image', [
        'wpml_cf_preferences' => 3,
        'mime_type' => 'jpg, webp',
        'preview_size'  => 'thumbnail',
        'instructions'  => 'Upload JPG or WebP images at 8x5.',
      ])
        ->conditional('is_image_background', '==', 1)
      ->addSelect('color', COLOR_SELECT)
        ->conditional('is_image_background', '==', 0)

      ->addFields($this->get(Copy::class))
        ->removeField('cta')

      ->addGroup('form')
        ->addRadio('type', [
          'wpml_cf_preferences' => 1,
          'layout' => 'vertical',
          'choices' => [
            'gravityforms' => 'Gravity Forms',
            'embed' => 'Embed Code'
            // 
          ],
          'default_value' => 'gravityforms',
        ])
        ->addText('headline', [
          'wpml_cf_preferences' => 2,
          'maxlength' => 250
        ])
          ->conditional('type', '==', 'gravityforms')
        ->addTextarea('copy', [
          'wpml_cf_preferences' => 2,
          'rows'  => 4,
          'new_lines' => 'wpautop'
        ])
          ->conditional('type', '==', 'gravityforms')
        ->addField('gravityforms', 'forms')
          ->conditional('type', '==', 'gravityforms')
        ->addTextarea('embed', [
          'wpml_cf_preferences' => 2
        ])
          ->conditional('type', '==', 'embed')
      ->endGroup()
      ;

    return $form->build();
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
