<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $table = 'agendas';
      protected $fillable = ['fecha', 'hora', 'id_paciente'];
      protected $dates = ['created_at', 'updated_at'];

      public function paciente()
      {
          return $this->belongsTo(Paciente::class, 'id_paciente');
      }
}
