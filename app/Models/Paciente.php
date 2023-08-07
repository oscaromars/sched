<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;
    protected $table = 'pacientes';
    protected $fillable = ['cedula', 'Apellidos', 'Nombres'];
    protected $dates = ['created_at', 'updated_at'];
}
