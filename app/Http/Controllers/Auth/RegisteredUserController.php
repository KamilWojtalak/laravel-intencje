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
        $this->handleLogic($request, Role::ROLE_USER);

        return redirect(route('dashboard', absolute: false));
    }

    public function storePriest(Request $request): RedirectResponse
    {
        $this->handleLogic($request, Role::ROLE_PARISH);

        return redirect(route('dashboard', absolute: false));
    }

    private function handleLogic(Request $request, string $role): void
    {
        $this->validateUserRequest($request);

        $user = $this->createUser($request);

        $this->handleUserRole($user, $role);

        event(new Registered($user));

        Auth::login($user);
    }

    private function validateUserRequest(Request $request): void
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
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

    private function handleUserRole(User $user, string $role): void
    {
        $role = Role::getByName(Role::ROLE_USER);

        if ($role) {
            $user->roles()->attach($role);
        }
    }
}
