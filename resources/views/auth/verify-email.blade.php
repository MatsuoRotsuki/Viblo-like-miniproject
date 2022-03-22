<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, bạn có thể xác thực địa chỉ email bằng cách click vào link chúng tôi vừa gửi cho bạn được không? Nếu bạn chưa nhận được email, chúng tôi sẽ gửi cho bạn một email khác. Kiểm tra kỹ trong thùng thư spam của bạn.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Một liên kết xác thực đã được gửi tới địa chỉ email mà bạn cung cấp khi đăng ký.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Gửi Lại Email Xác Thực') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Đăng Xuất') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
