<x-guest-layout>
    {{-- <link rel="shortcut icon" href="{{ asset('site/img/logo.png') }}" type="image/x-icon"> --}}
    <x-jet-authentication-card>
        <img src="{{asset('site/img/menuLogo_original.png')}}" class="w-25 h-25" alt="Logo do site">
        <x-slot name="logo">
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 mt-5">
            {{ __('Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e nós enviaremos um link de redefinição de senha que permitirá que você escolha uma nova.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email com link para resetar senha') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
