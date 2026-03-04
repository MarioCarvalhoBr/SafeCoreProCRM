<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        // Validação de Segurança estrita (Whitelist): Só aceita estes 3 idiomas
        if (array_key_exists($lang, ['en' => 'English', 'pt' => 'Portuguese', 'es' => 'Spanish'])) {
            Session::put('applocale', $lang);
        }

        // Retorna para a página de onde o usuário veio
        return redirect()->back();
    }
}
