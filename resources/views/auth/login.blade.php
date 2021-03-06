<x-guest-layout>
	<x-auth-card>
		<x-slot name="logo">
			<a href="/">
				<x-application-logo class="w-80 h-80 fill-current text-gray-500" />
			</a>
		</x-slot>

		<x-auth-session-status class="mb-4" :status="session('status')" />
		<x-auth-validation-errors class="mb-4" :errors="$errors" />

		<form class='space-y-2' method="POST" action="{{ route('login') }}">
			@csrf

			<x-form.input name="login" autofocus required />
			<x-form.input name="password" type="password" autocomplete="current-password" required />
			<x-form.checkbox name="remember_me" />

			<div class="flex items-center justify-end mt-4 space-x-3">
				<x-button class="bg-indigo-500" onclick="window.location.href='{{ config('services.discord.oauth2url.login') }}'" type="button">
					<div class="fab fa-discord mr-2"></div>
					{{ __('login.register') }}
				</x-button>

				<x-button>
					{{ __('login.button') }}
				</x-button>
			</div>

			@if (Route::has('password.request'))
				<a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
					{{ __('login.forgot') }}
				</a>
			@endif
		</form>
	</x-auth-card>
</x-guest-layout>
