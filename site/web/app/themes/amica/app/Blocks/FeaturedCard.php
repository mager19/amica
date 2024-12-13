<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
require_once __DIR__ . '/../../functions/definitions.php';

class FeaturedCard extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Featured Card';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Featured Post Card';

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
        'background'            => false,
        'headline'              => 'This is a headline',
        'image_background'      => false,
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {

        $featured_post = get_field('featured_post_' . get_field('post_type')) ? get_field('featured_post_' . get_field('post_type'))[0] : null;

        return [
            'card'           => $this->buildCard($featured_post),
            'background'     => get_field('color') ?: $this->example['background'],
        ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $featured_card = new FieldsBuilder('featured_card', [
            'label_placement'   => 'left'
        ]);

        $featured_card
          ->addSelect('color', COLOR_SELECT)
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
          
          ->addRelationship('featured_post_post', [
            'label' => 'Featured Post',
            'required' => 1,
            'post_type' => ['post'],
            'taxonomy' => [],
            'filters' => [
                0 => 'search',
                2 => 'category',
            ],
            'max' => '1',
            'return_format' => 'object',
          ])
            ->conditional('post_type', '==', 'post')
          ->addRelationship('featured_post_story', [
            'label' => 'Featured Post',
            'required' => 1,
            'post_type' => ['story'],
            'taxonomy' => [],
            'filters' => [
                0 => 'search',
                2 => 'category',
            ],
            'max' => '1',
            'return_format' => 'object',
          ])
            ->conditional('post_type', '==', 'story')
          ;

        return $featured_card->build();
    }

    /**
     * Build card from post.
     *
     * @return void
     */
    public function buildCard($post)
    {
      if ( !$post ) return null;
      $card = extractPostCard($post);
      $post_type = get_field('post_type') == 'post' ? __('article', 'amica') : get_field('post_type');
      $card['eyebrow'] = 'Featured ' . $post_type;
      return $card;
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
