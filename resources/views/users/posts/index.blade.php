<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div>
                        <h1 class="text-2xl font-bold mb-4" style="font-size:2rem">{{$user->username }}</h1>
                        <p class="mb-4">Posted {{ $posts->count() }} {{Str::plural('post', $posts->count()) }} and received {{ $user->receivedLikes->count() }} {{ Str::plural('like', $user->receivedLikes->count()) }}</p>
                    </div>
                    @if($posts->count())
                        @foreach ($posts as $post)
                            <x-post :post="$post" />
                        @endforeach

                        {{ $posts->links() }}
                    @else
                        <p>{{ $user->username }} does not have any posts</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
