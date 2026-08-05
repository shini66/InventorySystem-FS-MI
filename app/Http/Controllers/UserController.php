<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->when(request('search'), fn ($q, $s) => $q->where('name', 'like', '%'.$s.'%'))
            ->orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
            'role' => ['sometimes', 'required', 'in:admin,operator'],
        ]);

        $isSelf = $user->is(auth()->user());

        if ($isSelf) {
            unset($data['role']);
        }

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        $message = $isSelf ? 'Usuario actualizado.' : 'Usuario actualizado a '.$data['role'].'.';

        return redirect()->route('users.index')->with('success', $message);
    }
}
