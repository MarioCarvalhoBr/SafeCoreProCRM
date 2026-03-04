<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tenant extends Model
{
    use HasFactory, LogsActivity;

    // Proteção de segurança: Define estritamente quais dados podem ser inseridos via formulário
    protected $fillable = [
        'name',
        'description',
        'logo_path',
        'banner_path',
        'email',
        'phone',
    ];

    // 3. Configuração:
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
