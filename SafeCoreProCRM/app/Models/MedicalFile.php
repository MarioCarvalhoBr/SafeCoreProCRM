<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalFile extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'original_name', 'file_path', 'mime_type'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
