<x-guest-layout>
    {{-- <link rel="shortcut icon" href="{{ asset('site/img/logo.png') }}" type="image/x-icon"> --}}
    <x-jet-authentication-card>
        <img src="{{asset('site/img/menuLogo_original.png')}}" class="w-25 h-25" alt="Logo do site">
        <x-slot name="logo">
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Senha') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            {{-- <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div> --}}

            <div style="mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Esqueceu sua senha?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-5">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('termos') }}" target="_blank">
                    {{ __('Ao entrar com uma rede social, você concorda com os Termos de Uso e Política de Privacidade, clique aqui para visualizar.') }}
                </a>
            </div>

            <div class="mt-2">
                <a class="underline text-sm text-green-600 hover:text-green-900" href="{{ route('login.rede.social', ['provider' => 'github']) }}" data-placement="top" data-toggle="tooltip" title="Entre usando suas credenciais do GitHub">
                    {{ __('Entrar com GitHub') }}
                </a>
            </div>

            <div class="mt-2">
                <a class="underline text-sm text-blue-600 hover:text-blue-900" href="{{ route('login.rede.social', ['provider' => 'facebook']) }}" data-placement="top" data-toggle="tooltip" title="Entre usando suas credenciais do FaceBook">
                    {{ __('Entrar com Facebook') }}
                </a>
            </div>

            <div class="mt-2">
                <a class="underline text-sm text-yellow-600 hover:text-yellow-900" href="{{ route('login.rede.social', ['provider' => 'google']) }}" data-placement="top" data-toggle="tooltip" title="Entre usando suas credenciais do Google">
                    {{ __('Entrar com Google') }}
                </a>
            </div>

            {{-- <div style="margin-top: 5px">
                <a class="underline text-sm text-azure-600 hover:text-azure-900" href="{{ route('login.rede.social', ['provider' => 'twitter']) }}">
                    {{ __('Entrar com Twitter') }}
                </a>
            </div> --}}

            <div class="flex items-center justify-end mt-4">

                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('Não tem cadastro?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Entrar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
