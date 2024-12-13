<?php

namespace App\Blocks;

define('COLOR_SELECT', [
  'wpml_cf_preferences' => 1,
  'instructions' => '
      <p class="subhead pl-3">Options:</p>
      <div class="color-options pl-3">
        <p class="bg-white">White</p>
        <p class="bg-bedrock">Bedrock</p>
        <p class="bg-golden">Golden</p>
        <p class="bg-verdant">Verdant</p>
      </div>
  ',
  'choices'       => [
      'white'   => 'White',
      'bedrock' => 'Bedrock',
      'golden'  => 'Golden',
      'verdant' => 'Verdant',
  ],
  'return_format' => 'value',
]);

define('CURRENT_LANGUAGE', apply_filters( 'wpml_current_language', NULL ));