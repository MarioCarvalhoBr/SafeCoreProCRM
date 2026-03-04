<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantController extends Controller
{
    // Mostra o formulário de configuração
    public function edit()
    {
        // Padrão Singleton: Pega a 1ª configuração ou cria uma em branco na memória
        $tenant = Tenant::first() ?? new Tenant();
        return view('tenant.edit', compact('tenant'));
    }

    // Processa os dados e os uploads
    public function update(Request $request)
    {
        // 1. Validação Estrita (O Segurança da Porta)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            // Valida as imagens: só aceita jpg/png/webp e no máximo 2MB (2048 kilobytes)
            'logo' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ]);

        $tenant = Tenant::first() ?? new Tenant();
        $tenant->name = $request->name;
        $tenant->email = $request->email;
        $tenant->phone = $request->phone;
        $tenant->description = $request->description;

        // 2. Lógica Segura de Upload da LOGO
        if ($request->hasFile('logo')) {
            // Se já existia uma logo antiga, nós a deletamos do servidor para não lotar o HD
            if ($tenant->logo_path && Storage::disk('public')->exists($tenant->logo_path)) {
                Storage::disk('public')->delete($tenant->logo_path);
            }
            // Salva a nova imagem na pasta 'storage/app/public/logos' de forma criptografada
            $tenant->logo_path = $request->file('logo')->store('logos', 'public');
        }

        // 3. Lógica Segura de Upload do BANNER
        if ($request->hasFile('banner')) {
            if ($tenant->banner_path && Storage::disk('public')->exists($tenant->banner_path)) {
                Storage::disk('public')->delete($tenant->banner_path);
            }
            $tenant->banner_path = $request->file('banner')->store('banners', 'public');
        }

        $tenant->save();

        return redirect()->back()->with('status', 'settings-updated');
    }
}
