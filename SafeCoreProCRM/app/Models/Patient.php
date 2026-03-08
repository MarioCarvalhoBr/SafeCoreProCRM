<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Appointment;
use App\Models\MedicalRecord;

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

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function appointments()
    {
        // Um paciente "tem muitos" agendamentos
        return $this->hasMany(Appointment::class);
    }
}
