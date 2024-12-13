<article @php(post_class())>
    <x-subhead size="1">{!! $title !!}</x-subhead>
    {{-- <pre>$post: {{ var_dump($post) }}</pre> --}}
    <x-subhead size="3">{!! get_field('title') !!}</x-subhead>
    <x-body size="2"><a href="mailto:{!! get_field('contact') !!}">{!! get_field('contact') !!}</a></x-body>
</article>
