<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MedicalRecord extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'patient_id', 'blood_type', 'allergies', 'family_history', 'past_surgeries', 'current_medications'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
