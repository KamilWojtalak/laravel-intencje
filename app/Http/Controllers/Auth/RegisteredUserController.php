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
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function createPriest(): View
    {
        return view('auth.register-priest');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateUserRequest($request, Role::ROLE_USER);

        $user = $this->createUser($request);

        $this->handleUserRole($request, $user, Role::ROLE_USER);

        $this->handleUserPriest($request, $user);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function storePriest(Request $request): RedirectResponse
    {
        $this->validateUserRequest($request, Role::ROLE_PARISH);

        $user = $this->createUser($request);

        $this->handleUserRole($request, $user, Role::ROLE_PARISH);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function validateUserRequest(Request $request, string $role): void
    {
        if ($this->itIsUserRegistration($role)) {
            $request->validate([
                'priest_id' => [
                    'required',
                    Rule::exists('users', 'id'),
                ],
            ]);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    }

    private function handleUserPriest(Request $request, User $user): void
    {
        $priest = User::find($request->get('priest_id'));

        if (!$priest) {
            ValidationException::withMessages([
                'role' => ['Invalid priest id'],
            ]);
        }

        $user->prists()->attach($priest);
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

    private function handleUserRole(Request $request, User $user, string $roleName): void
    {
        $role = Role::getByName($roleName);

        if (!$role) {
            ValidationException::withMessages([
                'role' => ['Invalid role id'],
            ]);
        }

        $user->roles()->attach($role);
    }

    private function itIsUserRegistration(string $role): bool
    {
        return $role === Role::ROLE_USER;
    }
}
