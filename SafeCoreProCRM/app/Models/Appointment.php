<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes'
    ];

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
