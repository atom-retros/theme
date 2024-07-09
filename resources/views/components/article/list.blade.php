@props(['articles'])

<div {{ $attributes->merge(['class' => 'grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4']) }}>
    @if ($slot->isEmpty())
        @foreach ($articles as $article)
            <x-theme::article.item :article="$article" />
        @endforeach
    @else
        {{ $slot }}
    @endif
</div>