
<section class="bg-white gap-wide">
  <div class="fluid-container grid-12 col-span-full">
    <div class="col-span-full">
      <x-display html="h2" class="mb-inner" id="design-system">Design System</x-display>
    </div>
  </div>
  <div class="fluid-container grid-12 col-span-full">
    <div class="col-span-full">
      <x-subhead html="h3" class="mb-inner" id="buttons">Buttons and color modes</x-subhead>
      <div class="mb-half">
        <x-subhead size="2" html="h4">White</x-subhead>
        <div class="flex w-full flex-wrap justify-around items-center mb-0 p-narrow bg-white">
          <x-body size="2" class="mb-0">Body Text</x-body>
          <x-body html="a" href="#" size="2" class="mb-0">Body link</x-body>
          <x-button html="a" href="#">Regular Button</x-button>
          <x-button html="a" href="#" type="border">Button Border</x-button>
          <x-button html="a" href="#" type="link">Button Link</x-button>
          <x-button html="a" href="#" type="link" icon="arrow-right">Button Link Icon</x-button>
        </div>
      </div>
      <div class="mb-half">
        <x-subhead size="2" html="h4">Dark</x-subhead>
        <div class="flex w-full flex-wrap justify-around items-center mb-0 p-narrow bg-dark">
          <x-body size="2" class="mb-0">Body Text</x-body>
          <x-body html="a" href="#" size="2" class="mb-0">Body link</x-body>
          <x-button html="a" href="#">Regular Button</x-button>
          <x-button html="a" href="#" type="border">Button Border</x-button>
          <x-button html="a" href="#" type="link">Button Link</x-button>
          <x-button html="a" href="#" type="link" icon="arrow-right">Button Link Icon</x-button>
        </div>
        <p class="flex w-full flex-wrap justify-around items-center mb-0 p-narrow bg-white">
          <x-button html="a" href="#" color="dark">Dark</x-button>
          <x-button html="a" href="#" color="dark" type="border">Dark Border</x-button>
          <x-button html="a" href="#" color="dark" type="link">Dark Link</x-button>
          <x-button html="a" href="#" color="dark" type="link" icon="arrow-right">Dark Link Icon</x-button>
        </p>
      </div>
      <div class="mb-half">
        <x-subhead size="2" html="h4">Bedrock</x-subhead>
        <div class="flex w-full flex-wrap justify-around items-center mb-0 p-narrow bg-bedrock">
          <x-body size="2" class="mb-0">Body Text</x-body>
          <x-body html="a" href="#" size="2" class="mb-0">Body link</x-body>
          <x-button html="a" href="#">Regular Button</x-button>
          <x-button html="a" href="#" type="border">Button Border</x-button>
          <x-button html="a" href="#" type="link">Button Link</x-button>
          <x-button html="a" href="#" type="link" icon="arrow-right">Button Link Icon</x-button>
        </div>
      </div>
      <div class="mb-half">
        <x-subhead size="2" html="h4">Verdant</x-subhead>
        <div class="flex w-full flex-wrap justify-around items-center mb-0 p-narrow bg-verdant">
          <x-body size="2" class="mb-0">Body Text</x-body>
          <x-body html="a" href="#" size="2" class="mb-0">Body link</x-body>
          <x-button html="a" href="#">Regular Button</x-button>
          <x-button html="a" href="#" type="border">Button Border</x-button>
          <x-button html="a" href="#" type="link">Button Link</x-button>
          <x-button html="a" href="#" type="link" icon="arrow-right">Button Link Icon</x-button>
        </div>
      </div>
      <div class="mb-half">
        <x-subhead size="2" html="h4">Golden</x-subhead>
        <div class="flex w-full flex-wrap justify-around items-center mb-0 p-narrow bg-golden">
          <x-body size="2" class="mb-0">Body Text</x-body>
          <x-body html="a" href="#" size="2" class="mb-0">Body link</x-body>
          <x-button html="a" href="#">Regular Button</x-button>
          <x-button html="a" href="#" type="border">Button Border</x-button>
          <x-button html="a" href="#" type="link">Button Link</x-button>
          <x-button html="a" href="#" type="link" icon="arrow-right">Button Link Icon</x-button>
        </div>
      </div>
    </div>
  </div>
  <div class="fluid-container grid-12 col-span-full">
    <div class="col-span-full">
      <x-subhead html="h3" class="mb-inner" id="typography">Typography</x-subhead>
      <x-display size="mega" html="p">Display Mega</x-display>
      <x-display size="super" html="p">Display Super</x-display>
      <x-display size="1" html="p">Display 1</x-display>
      <x-display html="p">Display 2</x-display>
      <x-subhead html="p">Subhead 1</x-subhead>
      <x-subhead html="p" size="2">Subhead 2</x-subhead>
      <x-subhead html="p" size="3">Subhead 3</x-subhead>
      <x-subhead html="p" size="4">Subhead 4</x-subhead>
      <x-body html="p">Body Large</x-body>
      <x-body html="p" type="secondary">Body Large Secondary</x-body>
      <x-body html="p"><a href="#typography">Body Large Link</a></x-body>
      <x-body size="2" html="p">Body Small</x-body>
      <x-body size="2" type="secondary" html="p">Body Small Secondary</x-body>
      <x-body size="2" html="p"><a href="#typography">Body Small Link</a></x-body>
      <x-u-i-text html="p">UI Text</x-u-i-text>
    </div>
  </div>
  <div class="fluid-container grid-12 col-span-full">
    <div class="col-span-full">
      <x-subhead html="h3" class="mb-inner" id="spacing">Spacing</x-subhead>
      <div>
        <p class="flex gap-min flex-wrap items-center">
          <span class="bg-dark p-min flex items-center text-center">Padding Min</span>
          <span class="bg-bedrock p-inner flex items-center text-center">Padding Inner</span>
          <span class="bg-verdant p-half flex items-center text-center">Padding Half</span>
          <span class="bg-golden p-full flex items-center text-center">Padding Full</span>
          <span class="bg-dark p-max flex items-center text-center">Padding Max</span>
        </p>
        <p class="flex gap-min flex-wrap items-center">
          <span class="bg-dark p-narrow flex items-center text-center">Gutter Narrow</span>
          <span class="bg-bedrock p-wide flex items-center text-center">Gutter Wide</span>
        </p>
      </div>
    </div>
  </div>
  <div class="fluid-container grid-12 col-span-full">
    <div class="col-span-full">
      <x-subhead html="h3" class="mb-inner" id="rounded-corners">Rounded Corners</x-subhead>
      <div>
        <p class="flex gap-min flex-wrap md:flex-nowrap items-center">
          <span class="bg-dark h-72 w-full p-inner flex items-center text-center justify-center rounded-card">Card</span>
          <span class="bg-bedrock h-72 w-full p-min flex items-center text-center justify-center rounded-image">Image</span>
          <span class="bg-golden h-72 w-full p-half flex items-center text-center justify-center rounded-block">Block</span>
        </p>
      </div>
    </div>
  </div>
  <div class="fluid-container grid-12 col-span-full">
    <div class="col-span-full">
      <x-subhead html="h3" class="mb-inner" id="icons">Icons</x-subhead>
      <div>
        <p>
          arrow-right: {!! getSvg('icons/arrow-right', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          arrow-left: {!! getSvg('icons/arrow-left', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          arrow-next: {!! getSvg('icons/arrow-next', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          arrow-prev: {!! getSvg('icons/arrow-prev', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          arrow-down: {!! getSvg('icons/arrow-down', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          mail: {!! getSvg('icons/mail', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          search: {!! getSvg('icons/search', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          sort: {!! getSvg('icons/sort', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          v: {!! getSvg('icons/v', ['class' => 'inline w-8 h-8']) !!}
        </p>
        <p>
          x: {!! getSvg('icons/x', ['class' => 'inline w-8 h-8']) !!}
        </p>
      </div>
    </div>
  </div>
</section>
