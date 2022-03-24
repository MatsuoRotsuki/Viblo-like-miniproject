@props(['post' => $post])

<div class="mb-4">
    <a href="{{ route('users.posts', $post->user) }}" class="font-bold pr-3">{{ $post->user->firstname}} {{ $post->user->lastname }}</a><span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>

    <p class="mb-2">{{ $post->body }}</p>

    @can('delete', $post)
        <form action="{{ route('posts.destroy', $post) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-blue-500">Xóa</button>
        </form>
    @endcan

    <div class="flex items-center">

        <!-- Like/Unlike -->
        @auth
            @if(!$post->likedBy(auth()->user()))
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500"> Thích </button>
                </form>

            @else
                <form action="{{ route('posts.likes', $post) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500">Bỏ thích</button>
                </form>
            @endif
        @endauth

        <!-- Render likes number -->
        <span>{{ $post->likes->count() }}  {{ Str::plural('like', $post->likes->count()) }}</span>

    </div>

     <!-- Comment/Bookmark -->
    <div class="flex items-center">
        @auth
            @if(!$post->bookmarkedBy(auth()->user()))
                <form action="{{ route('posts.bookmark', $post) }}" method="post" class="mr-1"> <!-- route('posts.bookmark') -->
                    @csrf
                    <button type="submit" class="text-blue-500"> Lưu bài viết </button>
                </form>
            @else
                <form action="{{ route('posts.bookmark', $post) }}" method="post" class="mr-1"> <!-- route('posts.bookmark') -->
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-500"> Bỏ lưu </button>
                </form>
            @endif
        @endauth
    </div>
    <div class="mb-4 ml-12">
        <div class="mb-2 text-sm text-gray-900">
            <p>{{ $post->comments()->count() }} Bình luận</p>
        </div>
        <div>
            @if ($post->comments()->count())
                @foreach ($post->comments as $comment)
                    <a href="{{ route('users.posts', $comment->user) }}" class="font-bold pr-3">{{ $comment->user->firstname}} {{ $comment->user->lastname }}</a><span class="text-gray-600 text-sm">{{ $comment->created_at->diffForHumans() }}</span>

                    <p class="mb-2"> {{ $comment->commentbody }}</p>

                    <!-- Delete comments -->
                    @can('delete', $comment)
                        <form action=" {{ route('comments.destroy', $comment) }} " method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-500"> Xóa </button>
                        </form>
                    @endcan

                @endforeach
            @endif
        </div>
        <form action="{{ route('comments', $post) }}" method="POST">
            @csrf
            <div class="mb-1 mt-1">
                <label for="commentbody" class="sr-only">Comment</label>
                <textarea name="commentbody" id="commentbody" cols="15" rows="1" class="bg-gray-100 border-2 w-full p-4 rounded-lg" placeholder="Viết bình luận công khai!"></textarea>
                @error('commentbody')
                    <div class="text-red-500 mt-2 text-sm">
                        Bạn phải viết bình luận thì mới đăng được! {{ auth()->user()->firstname }} ơi
                    </div>
                @enderror
            </div>

            <div>
                <button class="text-white px-4 py-2 rounded font-medium items-end" style="background-color:rgb(42, 153, 61)">Đăng</button>
            </div>
        </form>
    </div>
</div>
