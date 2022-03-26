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
            @if(!$post->likedBy( auth()->user() ))
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

    <div class="flex items-center">
        <!-- VoteUp/VoteDown Post -->
        @auth
            @if (!$post->votedBy(auth()->user()))
                <form action="{{ route('posts.vote', ['post' => $post, 'vote' => 'up']) }}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500"> [+] </button>
                </form>

                <form action="{{ route('posts.vote', ['post' => $post, 'vote' => 'down']) }}" method="post" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500"> [-] </button>
                </form>
            @else
                @if($post->votes->where('user_id', auth()->user()->id)->contains('vote', 'up'))
                    <form action="{{ route('posts.unvote', ['post' => $post]) }}" method="post" class="mr-1">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="text-green-600"> [+] </button>
                    </form>
                    <form action="{{ route('posts.vote', ['post' => $post, 'vote' => 'down']) }}" method="post" class="mr-1">
                        @csrf
                        <button type="submit" class="text-blue-500"> [-] </button>
                    </form>
                @else
                    <form action="{{ route('posts.vote', ['post' => $post, 'vote' => 'up']) }}" method="post" class="mr-1">
                        @csrf
                        <button type="submit" class="text-blue-500"> [+] </button>
                    </form>
                    <form action="{{ route('posts.unvote', ['post' => $post]) }}" method="post" class="mr-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-green-600"> [-] </button>
                    </form>
                @endif
            @endif
        @endauth

        <span>
            @if ( $post->votes->where('vote', 'up')->count() - $post->votes->where('vote', 'down')->count() > 0 )
                +{{ $post->votes->where('vote', 'up')->count() - $post->votes->where('vote', 'down')->count() }}
            @else
                {{ $post->votes->where('vote', 'up')->count() - $post->votes->where('vote', 'down')->count() }}
            @endif
        </span>

    </div>

     <!-- Bookmark -->
    <div>
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

    <!-- Comment -->
    <div class="mb-4 ml-12">
        <div class="mb-2 text-sm text-gray-900">
            <p>{{ $post->comments()->count() }} Bình luận</p>
        </div>
        <div>
            @if ($post->comments()->count())
                @foreach ($post->comments as $comment)
                    <a href="{{ route('users.posts', $comment->user) }}" class="font-bold pr-3">{{ $comment->user->firstname}} {{ $comment->user->lastname }}</a><span class="text-gray-600 text-sm">{{ $comment->created_at->diffForHumans() }}</span>

                    <p> {{ $comment->commentbody }}</p>

                    <!-- Delete comments -->
                    @can('delete', $comment)
                        <form action=" {{ route('comments.destroy', $comment) }} " method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-500"> Xóa </button>
                        </form>
                    @endcan

                    <!-- Vote up/down comments -->
                    <div class="flex items-center">
                        @auth
                            @if (!$comment->votedBy( auth()->user() ))
                                <form action="{{ route('comments.vote', ['comment' => $comment, 'vote' => 'up']) }}" method="POST" class="mr-1">
                                    @csrf
                                    <button type="submit" class="text-blue-500"> [+] </button>
                                </form>

                                <form action="{{ route('comments.vote', ['comment' => $comment, 'vote' => 'down']) }}" method="POST" class="mr-1">
                                    @csrf
                                    <button type="submit" class="text-blue-500"> [-] </button>
                                </form>
                            @else
                                @if ($comment->votes->where('user_id', auth()->user()->id)->contains('vote', 'up'))

                                    <form action="{{ route('comments.unvote', ['comment' => $comment]) }}" method="POST" class="mr-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-green-600"> [+] </button>
                                    </form>

                                    <form action="{{ route('comments.vote', ['comment' => $comment, 'vote' => 'down']) }}" method="POST" class="mr-1">
                                        @csrf
                                        <button type="submit" class="text-blue-500"> [-] </button>
                                    </form>

                                @else

                                    <form action="{{ route('comments.vote', ['comment' => $comment, 'vote' => 'up']) }}" method="POST" class="mr-1">
                                        @csrf
                                        <button type="submit" class="text-blue-500"> [+] </button>
                                    </form>

                                    <form action="{{ route('comments.unvote', ['comment' => $comment]) }}" method="POST" class="mr-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-green-600"> [-] </button>
                                    </form>

                                @endif
                            @endif
                        @endauth
                        <span>
                            @if ( $comment->votes->where('vote', 'up')->count() - $comment->votes->where('vote', 'down')->count() > 0 )
                                +{{ $comment->votes->where('vote', 'up')->count() - $comment->votes->where('vote', 'down')->count() }}
                            @else
                                {{ $comment->votes->where('vote', 'up')->count() - $comment->votes->where('vote', 'down')->count() }}
                            @endif
                        </span>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Comment post -->
        <form action="{{ route('posts.comment', $post) }}" method="POST">
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

        <!-- Divider Line -->
    </div>
</div>
