<?php

namespace App\Fields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

use App\Fields\Partials\AlertType;

class SingleCampaign extends Field {
  /**
   * The field group.
   *
   * @return array
   */
  public function fields() {
    $campaign = new FieldsBuilder('campaign');

    $campaign
      ->setLocation('post_type', '==', 'campaign');

    $campaign
      ->addGroup('action', [
        'wpml_cf_preferences' => 1,
      ])
        ->addButtonGroup('form_type', [
          'wpml_cf_preferences' => 1,
          'required' => 1,
          'choices' => [
            'internal' => 'Internal (Gravity Forms)',
            'external' => 'External (Code embed)',
          ],
          'default_value' => 'internal',
          'return_format' => 'value',
        ])
        ->addField('form', 'forms')
          ->conditional('form_type', '==', 'internal')
        ->addTextarea('embed_code', [
            'wpml_cf_preferences' => 1,
            'conditional_logic' => [
              [
                [
                  'field' => 'form_type',
                  'operator' => '==',
                  'value' => 'external',
                ],
              ],
            ],
        ])
      ->endGroup()
      ->addGroup('thank_you')
        ->addText('title', [
            'wpml_cf_preferences' => 2,
            'default_value' => 'Thank You',
        ])
        ->addText('subhead', [
            'wpml_cf_preferences' => 2,
            'default_value' => 'Magnify the impact of your action',
        ])
        ->addWysiwyg('copy', [
            'wpml_cf_preferences' => 2,
        ])
        ->addTaxonomy('hashtags', [
          'wpml_cf_preferences' => 1,
          'taxonomy' => 'post_tag',
					'add_term' => 1,
					'save_terms' => 1,
					'load_terms' => 1,
					'return_format' => 'object',
					'field_type' => 'multi_select',
					'allow_null' => 1,
        ])
        ->addRepeater('social_share', [
          'wpml_cf_preferences' => 3,
					'layout' => 'block',
					'button_label' => 'Add Social Platform',
        ])
          ->addSelect('name', [
            'wpml_cf_preferences' => 1,
            'choices' => [
              'x' => 'X',
              'facebook' => 'Facebook',
              'linkedin' => 'Linkedin',
              'email' => 'Email',
              'whatsapp' => 'Whatsapp',
              'reddit' => 'Reddit',
            ],
          ])
          ->addTextarea('copy', [
            'wpml_cf_preferences' => 2,
            'conditional_logic' => [
              [
                [
                  'field' => 'name',
                  'operator' => '==',
                  'value' => 'x',
                ],
              ],
              [
                [
                  'field' => 'name',
                  'operator' => '==',
                  'value' => 'whatsapp',
                ],
              ],
              [
                [
                  'field' => 'name',
                  'operator' => '==',
                  'value' => 'email',
                ],
              ],
            ],
          ])
        ->endRepeater()
      ->endGroup()
      ;
      
    return $campaign->build();
  }
}
