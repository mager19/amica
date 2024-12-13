<?php

namespace App\Fields\Partials;

use Log1x\AcfComposer\Partial;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Copy extends Partial
{
    /**
     * The partial field group.
     *
     * @return array
     */
    public function fields()
    {
        $copy = new FieldsBuilder('copy');

        $copy
          ->addText('eyebrow', [
            'wpml_cf_preferences' => 2,
            'maxlength' => 250
          ])
          ->addText('headline', [
            'wpml_cf_preferences' => 2,
            'maxlength' => 250
          ])
          ->addText('subhead', [
            'wpml_cf_preferences' => 2,
            'maxlength' => 800
          ])
          ->addWysiwyg('copy', [
            'wpml_cf_preferences' => 2,
            'rows'  => 4,
            'new_lines' => 'wpautop'
          ])
          ->addLink('cta', [
            'wpml_cf_preferences' => 2,
            'label' => 'Call to Action',
          ]);

        return $copy;
    }
}

