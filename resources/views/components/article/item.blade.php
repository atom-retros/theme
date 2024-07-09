@props(['article', 'compact' => false])

<a href="{{ route('community.articles.show', $article) }}" {{ $attributes->merge(['class' => 'bg-white border rounded-lg shadow dark:border-gray-900 dark:bg-gray-900 dark:text-white transition-all hover:scale-105 group overflow-hidden']) }}>
    <figure class="{{ $compact ? 'h-12' : 'h-32' }}">
        <img src="{{ $article->image }}" alt="{{ $article->title }}" class="object-none object-right w-auto h-full min-w-full transition-all duration-500 max-w-none group-hover:object-center">
    </figure>
    <div class="flex flex-col gap-3 p-4">
        <p class="font-semibold truncate dark:text-white">{{ $article->title }}</p>

        @if (!$compact)
            <div class="flex items-center gap-3 truncate">
                <button class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded-full dark:bg-gray-800">
                    <img src="https://www.habbo.com/habbo-imaging/avatarimage?figure={{ $article->user->look }}&headonly=1" alt="{{ $article->user->username }}" />
                </button>
                <p class="text-sm font-semibold dark:text-white">{{ $article->user->username }}</p>
            </div>
        @endif
    </div>
</a>