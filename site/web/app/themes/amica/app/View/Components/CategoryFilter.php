<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class CategoryFilter extends Component {

  public $taxonomy_terms;
  public $taxonomy_slug;
  public $post_type;

  public function __construct(
    $taxonomyTerms = null,
    $postType = null,
    $taxonomySlug = 'category',
  ) {
    $this->post_type = $postType;
    if ( $postType === 'case' ) {
      
      $this->taxonomy_slug = [
        'legal_category' => [],
        'judge' => []
      ];
      foreach($this->taxonomy_slug as $tax => $info) {
        $this->taxonomy_slug[$tax] = [
          'name' => $tax === 'legal_category' ? 'Case categories' : "Case judges",
          'values' => $this->getTerms($tax)
        ];
      }
    } else {
      $this->taxonomy_slug = $taxonomySlug;
      $this->taxonomy_terms = $this->getTerms($taxonomySlug);
    }
  }

  public function getTerms($tax) {
    $taxonomyTerms = get_terms( array(
      'taxonomy' => $tax,
      'hide_empty' => true, // Exclude empty taxonomyTerms
    ) );
    if (is_wp_error($taxonomyTerms)) return [];
    $parentCategories = [];
    foreach($taxonomyTerms as $category) {
      if ( $category->parent ) { 
        if ( !isset($parentCategories[$category->parent]) ) $parentCategories[$category->parent] = [];
        $parentCategories[$category->parent][] = $category;
      }
    };

    foreach($taxonomyTerms as $category) {
      $name_plural = get_term_meta($category->term_id, '_plural', true);
      $category->name_plural = $name_plural !== '' ? $name_plural : $category->name;
      if (isset($parentCategories[$category->term_id])) $category->children = $parentCategories[$category->term_id];
    };
    $taxonomyTerms = array_filter($taxonomyTerms, static function ($element) {
        return $element->name !== "Uncategorized";
    });

    return $taxonomyTerms;
  }

  public function render() {
    return view('components.category-filter');
  }
}
