<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    // Proteção de segurança: Define estritamente quais dados podem ser inseridos via formulário
    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'banner_path',
        'email',
        'phone',
    ];
}
