<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Traz os usuários junto com seus papéis (Eager Loading para performance)
        $users = User::with('roles')->orderBy('name')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Busca todos os papéis disponíveis no banco
        $roles = Role::orderBy('name')->get();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|exists:roles,name', // Garante que o cargo existe
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Atribui o cargo escolhido usando o Spatie
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', __('messages.user_created_successfully'));
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        // Pega o nome do cargo atual do usuário para marcar no formulário
        $userRole = $user->roles->pluck('name')->first();

        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            // A senha é opcional na edição
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // syncRoles remove os cargos antigos e aplica o novo
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', __('messages.user_updated_successfully'));
    }

    public function destroy(User $user)
    {
        // TRAVA DE SEGURANÇA SÊNIOR: Não permite que o Admin logado se delete!
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => __('messages.cannot_delete_self')]);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', __('messages.user_deleted_successfully'));
    }
}
