<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Patient extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'email', 'phone', 'document_id', 'birth_date'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Rastreia todos os campos definidos no $fillable acima
            ->logOnlyDirty() // Só salva o log se algo realmente mudar
            ->dontSubmitEmptyLogs(); // Não cria logs vazios
    }
}
