<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;
use App\Fields\Partials\Copy;
require_once __DIR__ . '/../../functions/definitions.php';

class LatestPosts extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'Latest Posts';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Show the latest 3 News or Stories by Category';

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
    <rect x="2" y="4" width="6" height="7" fill="black"/>
    <rect x="9" y="4" width="6" height="7" fill="black"/>
    <rect x="16" y="4" width="6" height="7" fill="black"/>
    <rect x="2" y="12" width="6" height="1" fill="black"/>
    <rect x="9" y="12" width="6" height="1" fill="black"/>
    <rect x="16" y="12" width="6" height="1" fill="black"/>
    <rect x="2" y="14" width="6" height="1" fill="black"/>
    <rect x="9" y="14" width="6" height="1" fill="black"/>
    <rect x="16" y="14" width="6" height="1" fill="black"/>
    <rect x="2" y="16" width="6" height="1" fill="black"/>
    <rect x="9" y="16" width="6" height="1" fill="black"/>
    <rect x="16" y="16" width="6" height="1" fill="black"/>
    <rect x="2" y="18" width="3" height="2" fill="black"/>
    <rect x="9" y="18" width="3" height="2" fill="black"/>
    <rect x="16" y="18" width="3" height="2" fill="black"/>
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
        'headline'      => 'This is a headline',
        'cards_count'   => false,
    ];

    /**
     * Data to be passed to the block before rendering.
     *
     * @return array
     */
    public function with()
    {
      $post_type = get_field('post_type');
      $category = get_field('post_category') ?: get_field('story_category');
      $cards = $this->getCards($post_type, $category);

      $custom_card_color = $post_type === 'post' && get_field('color') == 'white';
  
      return [
        'is_folder_tab'   => $post_type === 'post',
        'background'      => get_field('color') ?: $this->example['background'],
        'eyebrow'         => get_field('eyebrow'),
        'headline'        => get_field('headline') ?: $this->example['headline'],
        'subhead'         => get_field('subhead'),
        'copy'            => get_field('copy'),
        'cta'             => get_field('cta'),
        'category'        => $category,
        'post_type'       => $post_type,
        'cards'           => $cards,
        'card_color'      => $custom_card_color ? get_field('card_color') : false,
        'cards_count'     => is_array($cards) ? count($cards) : 0,
      ];
    }

    /**
     * The block field group.
     *
     * @return array
     */
    public function fields()
    {
        $latest_posts = new FieldsBuilder('latest_posts', [
            'label_placement'   => 'left'
        ]);
        $post_categories = term_names('category') ?: [];
        $story_categories = term_names('story_category') ?: [];
        $latest_posts
          ->addTab('content')
            ->addFields($this->get(Copy::class))
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
            ->addRadio('post_category', [
              'choices'       => $post_categories,
              'allow_null' => 1,
              'default_value' => 0,
              'return_format' => 'value',
            ])
              ->conditional('post_type', '==', 'post')
            ->addRadio('story_category', [
              'choices'       => $story_categories,
              'allow_null' => 1,
              'default_value' => 0,
              'return_format' => 'value',
            ])
              ->conditional('post_type', '==', 'story')
          ->addTab('config')
            ->addSelect('color', COLOR_SELECT)
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
          

          ;

        return $latest_posts->build();
    }

    /**
     * Build card from post.
     *
     * @return void
     */
    private function getCards($post_type = 'post', $category = null) {
      $tax_query = null;
      if ($category) {
        $tax_query = [
          [
            'taxonomy' => $post_type == 'post' ? 'category' : 'story_category',
            'field'    => 'slug',
            'terms'    => $category
          ]
        ];
      }
      $latest_posts = get_posts([
        'post_type' => $post_type,
        'tax_query' => $tax_query,
        'posts_per_page' => '3'
      ]);
      $cards = array_map('extractPostCard', $latest_posts);
      wp_reset_postdata();
      return $cards;
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
