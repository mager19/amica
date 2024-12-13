@set($top, isset($top) ? $top : false)
@set($left, isset($left) ? $left : true)
@set($color, isset($color) ? $color : 'dark')
@set($border, isset($border) ? $border : true)

<aside>
<div class="{{ classNames([
  'partial--folder-tab z-higher-content relative !max-w-none',
  'color-' . $color . ' border-' . $color => $color !== 'text' && $color !== 'background',
  'text-var-' . $color . ' border-var-' . $color => $color == 'text' || $color == 'background',
  'border-b-[6px] md:border-b-8 lg:border-b-[10px]' => $border == true,
  'no-border' => $border == false,
  '-mt-[var(--tab-height)] !pt-0' => $top,
  '!pl-0' => $left == false,
]) }}" aria-hidden="true">
  <svg class="hidden text-inherit lg:flex -mb-px" width="187" height="25" viewBox="0 0 187 25" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M174.305 0H0V24.211H186.312L182.003 6.07219C181.158 2.51308 177.972 0 174.305 0Z" fill="currentColor"/>
  </svg>

  <svg class="hidden text-inherit md:flex lg:hidden -mb-px" width="139" height="21" viewBox="0 0 139 21" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M126.305 0H0V20.211H138.312L134.003 6.07219C133.158 2.51308 129.972 0 126.305 0Z" fill="currentColor"/>
  </svg>

  <svg class="flex text-inherit md:hidden -mb-px" width="80" height="15" viewBox="0 0 80 15" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M75.7219 4.00863C74.8769 1.60689 72.6081 0 70.062 0H0V14.211H79.3115L75.7219 4.00863Z" fill="currentColor"/>
  </svg>
</div>
</aside>
