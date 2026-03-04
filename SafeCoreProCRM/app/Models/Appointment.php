<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Appointment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'patient_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
        'certificate_days',
    ];

    // 3. Adicione o método de configuração:
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relacionamento: Um agendamento pertence a um Paciente
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Relacionamento: Um agendamento pertence a um Médico (User)
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
