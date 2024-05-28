<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    public function createPriest(): View
    {
        return view('auth.register-priest');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateUserRequest($request);

        $user = $this->createUser($request);

        // $role = Role::getByName(Role::ROLE_USER); // Pobieramy rolę o nazwie 'test'
        $role = Role::where('name', Role::ROLE_USER )->first(); // Pobieramy rolę o nazwie 'test'

        if ($role) {
            $user->roles()->attach($role); // Dodajemy użytkownika do roli
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function storePriest(Request $request): RedirectResponse
    {
        $this->validateUserRequest($request);

        $user = $this->createUser($request);

        // $role = Role::getByName(Role::ROLE_USER); // Pobieramy rolę o nazwie 'test'
        $role = Role::where('name', Role::ROLE_PARISH )->first(); // Pobieramy rolę o nazwie 'test'

        if ($role) {
            $user->roles()->attach($role); // Dodajemy użytkownika do roli
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function validateUserRequest(Request $request): void
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    private function createUser(Request $request): User
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }
}
