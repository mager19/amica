<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;
use App\Fields\Partials\Copy;
use WP_Query;
use WP_Term_Query;

class People extends Block
{
    /**
     * The block name.
     *
     * @var string
     */
    public $name = 'People';

    /**
     * The block description.
     *
     * @var string
     */
    public $description = 'Grid containing groups of internal personnel filtered by chosen category.';

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
    public $icon = 'dashicons-groups';

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
     * The ancestor block type allow list.
     *
     * @var array
     */
    public $ancestor = [];

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
        'jsx' => true
    ];

    /**
     * The block styles.
     *
     * @var array
     */
    public $styles = [];


    /**
     * The block template.
     *
     * @var array
     */
    // public $template = [
    //     'core/heading' => ['placeholder' => 'Hello World'],
    //     'core/paragraph' => ['placeholder' => 'Welcome to the People block.'],
    // ];

    /**
     * Data to be passed to the block before rendering.
     */
    public function with() {
        $term_id       = get_field('type') ?: null;
        $relationship  =  get_term_by('id', $term_id, 'relationship');
        $contact_email = get_term_meta($term_id, 'contact-email', true);
        $contact_label = get_term_meta($term_id, 'contact-label', true);

        return [
            'headline'  => isset($relationship->name) ? $relationship->name : null,
            'copy'      => isset($relationship->description) ? $relationship->description : null,
            'cta'       => $contact_email ? [
                'url'   => 'mailto:'. $contact_email,
                'title' => $contact_label ?: 'Email ' . $relationship->name,
                'target' => '_self',
              ] : null,
            'columns'   => get_field('columns') ?: 2,
            'items'     => $this->getPeopleAndPrograms($term_id),
            'term'      => isset($relationship->slug) ? $relationship->slug : false,
        ];
    }

    /**
     * The block field group.
     */
    public function fields(): array
    {
        $people = Builder::make('people');

        $relationships = $this->getRelationships();

        $people
            ->addSelect('type', [
                'choices'   => $relationships,
                'return_format' => 'both',
            ])
            ->addSelect('columns', [
                'instructions'  => 'Number of columns displayed for desktop devices.',
                'choices'   => [
                    2 => 2,
                    3 => 3,
                    4 => 4
                ]
            ])
            ;

        return $people->build();
    }

    /**
     * Retrieve the items.
     *
     * @return array
     */

    public function getRelationships() {

        $args = array(
            'taxonomy'      => 'relationship',
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => false,
        );

        $query_terms = new WP_Term_Query($args);

        $results = [
            [
                0 => '- Select a type -'
            ]
        ];

        foreach($query_terms->get_terms() as $term) {
            $results[] = [
                $term->term_id => $term->name
            ];
        }

        return $results;
    }

    public function getPeopleAndPrograms($term_id) {
        if($term_id == null) {
            return null;
            exit;
        }

        $args = array(
            'post_type'      => 'person',
            'post_status'    => 'publish',
            'posts_per_page' => 100,
            'meta_query'        => [
                'relation' => 'OR',
                [ 'key' => 'last', 'compare' => 'NOT EXISTS' ],
                [ 'key' => 'last', 'compare' => 'EXISTS' ],
            ],
            'orderby'        => 'meta_value title',
            'order'          => 'ASC',
            'tax_query' => array(
                'relation' => 'AND',
                array(
                    'taxonomy'  => 'relationship',
                    'field'     => 'term_id',
                    'operator'  => 'IN',
                    'terms'     => $term_id
                )
            )
        );

        $query_peeps = new WP_Query($args);

        $results = [];

        foreach($query_peeps->posts as $person) {
            $results[] = [
                'first'         => get_field('first', $person->ID),
                'last'          => get_field('last', $person->ID),
                'name'          => get_field('is_person', $person->ID) ? get_field('first', $person->ID) . ' ' . get_field('last', $person->ID) : $person->post_title,
                'title'         => get_field('title', $person->ID),
                'program'       => get_field('program', $person->ID),
                'email'         => get_field('email', $person->ID),
                'partner_logo'  => get_field('partner_logo', $person->ID),
                'is_person'     => get_field('is_person', $person->ID),
            ];
        }

        return $results;
    }

    /**
     * Assets enqueued when rendering the block.
     */
    public function assets(array $block): void
    {
        //
    }
}
