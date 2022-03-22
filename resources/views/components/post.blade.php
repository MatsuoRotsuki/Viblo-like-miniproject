@props(['post' => $post])

<div class="mb-4">
    <a href="{{ route('users.posts', $post->user) }}" class="font-bold pr-3">{{ $post->user->username }}</a><span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>

    <p class="mb-2">{{ $post->body }}</p>

    @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Xóa</button>
        </form>
    @endcan

    <div class="flex items-center">
        @auth
            @if(!$post->likedBy(auth()->user()))
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500">Thích</button>
                </form>

            @else
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Bỏ thích</button>
                </form>
            @endif
        @endauth

        <span>{{ $post->likes->count() }}  {{ Str::plural('like', $post->likes->count()) }}</span>

        @auth
            <form action="{{ route('posts.likes', $post) }}" method="post" class="mx-1">
                @csrf
                <button type="submit" class="text-blue-500"> Bình luận </button>
            </form>
            <form action="{{ route('login') }}" method="post" class="mx-1">
                @csrf
                <button type="submit" class="text-blue-500"> Lưu bài viết </button>
            </form>
        @endauth
    </div>
</div>