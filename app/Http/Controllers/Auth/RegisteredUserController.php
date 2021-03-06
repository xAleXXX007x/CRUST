<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\DiscordService;
use App\Providers\RouteServiceProvider;
use App\Rules\DiscordTag;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use NotificationChannels\Discord\Discord;

class RegisteredUserController extends Controller
{
    private $discordService;

    public function __construct(DiscordService $discordService)
    {
        $this->discordService = $discordService;
    }

    public function create(Request $request)
    {
        try
        {
            $userData = $this->discordService->getUserData($request->input('code'), config('services.discord.redirecturi.login'));

            $user = User::where('discord_id', $userData['id'])->first();

            if ($user) {
                return redirect()->route('login')->withErrors([
                    'discord' => $request->input('error_description', __('auth.already_registered'))
                ]);
            }

            return view('auth.register', [
                'discord_data' => $userData
            ]);
        } catch (Exception $e)
        {
            Log::error($e->getMessage());
            return redirect()->route('login')->withErrors([
                'discord' => $request->input('error_description', __('auth.discord_error'))
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:users'],
            'discord_tag' => ['required', new DiscordTag, 'unique:users'],
            'discord_id' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'age_confirmation' => ['accepted'],
            'rules_confirmation' => ['accepted']
        ]);

        $discordId = $request->discord_id;

        $user = User::create([
            'login' => $request->login,
            'discord_tag' => $request->discord_tag,
            'discord_id' => $discordId,
            'discord_private_channel_id' => app(Discord::class)->getPrivateChannel($discordId),
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
