<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('posts') }}" method="post" class="mb-4">
                        @csrf
                        <div class="mb-4">
                            <label for="body" class="sr-only"></label>
                            <textarea name="body" id="body" cols="30" rows="3" class="bg-gray-100 border-2 w-full p-2 rounded-lg @error('body') border-red-500 @enderror" placeholder="{{ auth()->user()->firstname }} ơi, bạn đang nghĩ gì thế?!"></textarea>
                            @error('body')
                                <div class="text-red-500 mt-2 text-sm">
                                    Bạn phải viết bài thì mới đăng được!
                                </div>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class=" text-white px-4 py-2 rounded font-medium" style="background-color:blue">Đăng</button>
                        </div>
                    </form>

                    @if($posts->count())
                        @foreach ($posts as $post)
                            <x-post :post="$post" />
                        @endforeach

                        {{ $posts->links() }}
                    @else
                        <p>Không có bài viết nào</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
