<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $categories = [
            'animales' => ['🐶','🐱','🐭','🐹','🐰','🦊','🐻','🐼','🐨','🐯','🦁','🐮','🐷','🐸','🐵','🐔','🐧','🐦','🐤','🦆','🦅','🦉','🐺','🐗','🐴','🦄','🐝','🐛','🦋','🐌','🐞','🐜','🦗','🦂','🐢','🐍','🦎','🦖','🦕','🐙','🦑','🦐','🦀','🐡','🐠','🐟','🐬','🐳','🐋','🦈','🐊'],
            'comida' => ['🍎','🍐','🍊','🍋','🍌','🍉','🍇','🍓','🍒','🍑','🥭','🍍','🥥','🥝','🍅','🍆','🥑','🥦','🥬','🥒','🌽','🥕','🍔','🍕','🌮','🌯','🥗','🍜','🍝','🍣','🍤','🥟','🍦','🍩','🍪','🎂','🍫','🍬','🍭'],
            'vehiculos' => ['🚗','🚕','🚙','🚌','🚎','🏎','🚓','🚑','🚒','🚐','🛻','🚚','🚛','🚜','🛵','🏍','🛺','🚲','🛴','🛹','🚀','🛸','🚁','✈️','🛩','🛰','🚂','🚃','🚄','🚢','⛵','🛶'],
            'caritas' => ['😀','😃','😄','😁','😆','😅','🤣','😂','🙂','😉','😊','😇','🥰','😍','🤩','😘','😋','😛','🤪','😝','🤑','🤗','🤭','🤔','🤐','😏','😒','🙄','😬','🥺','😢','😭','😱','😡','🤬','🥶','🤯'],
            'naturaleza' => ['🌸','🌺','🌻','🌹','🌷','🌿','🍀','🌵','🌴','🌲','🌳','🍄','🌾','💐','🌈','☀️','⛅','🌧','❄️','🔥','💧','🌊','⭐','🌙','☁️','⚡'],
        ];

        $categoryNames = [
            'animales' => 'animales',
            'comida' => 'alimentos',
            'vehiculos' => 'vehículos',
            'caritas' => 'caritas felices',
            'naturaleza' => 'elementos de la naturaleza',
        ];

        $catKeys = array_keys($categories);
        $selectedCat = $catKeys[array_rand($catKeys)];
        $correctEmojis = $categories[$selectedCat];

        $otherEmojis = [];
        foreach ($categories as $key => $emojis) {
            if ($key !== $selectedCat) {
                $otherEmojis = array_merge($otherEmojis, $emojis);
            }
        }

        $numCorrect = rand(3, 4);
        $selectedCorrect = [];
        $correctIndices = [];
        $correctPool = $correctEmojis;
        shuffle($correctPool);

        $allEmojis = [];
        $distractorPool = $otherEmojis;
        shuffle($distractorPool);

        for ($i = 0; $i < 9; $i++) {
            if ($i < $numCorrect && !empty($correctPool)) {
                $emoji = array_pop($correctPool);
                $selectedCorrect[] = $emoji;
                $correctIndices[] = $i;
                $allEmojis[] = $emoji;
            } else {
                $allEmojis[] = !empty($distractorPool) ? array_pop($distractorPool) : '❓';
            }
        }

        shuffle($allEmojis);

        $correctIndices = [];
        foreach ($allEmojis as $i => $emoji) {
            if (in_array($emoji, $selectedCorrect)) {
                $correctIndices[] = $i;
            }
        }

        session([
            'captcha_verified' => false,
            'captcha_category' => $categoryNames[$selectedCat],
            'captcha_correct' => $correctIndices,
        ]);

        return view('auth.login', [
            'captchaEmojis' => $allEmojis,
            'captchaCategory' => $categoryNames[$selectedCat],
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
