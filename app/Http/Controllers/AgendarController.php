<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Promise;

class AgendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function index(Request $request, $paciente = null, $numCitas = null, $diasDiferencia = null)
    {

          // Verificar si los parámetros son nulos y asignarles un valor predeterminado si es necesario
          $paciente = $paciente ?? $request->input('paciente');
          $numCitas = $numCitas ?? $request->input('num_citas');
          $diasDiferencia = $diasDiferencia ?? $request->input('dias_diferencia');


          $agendas = Agenda::all();
          $pacientes = Paciente::all();

          if ($paciente === null && $numCitas === null && $diasDiferencia === null) {
              // Proceso si los valores son nulos
              // ...

              $fechasHoras = [];

              for ($i = 0; $i < 100; $i++) {
                  $fecha = Carbon::now()->addDays($i);

                  // Omitir sábados y domingos
                  if ($fecha->isWeekday()) {
                      for ($j = 9; $j <= 16; $j++) {
                          $hora = $fecha->copy()->setTime($j, 0, 0)->format('H:i');

                          // Verificar que la fecha y hora no coincida con las agendas existentes
                          $horaCompleta = $hora . ':00';
                          $agendaExistente = $agendas->where('fecha', $fecha->format('Y-m-d'))
                              ->where('hora', $horaCompleta)
                              ->first();

                          if (!$agendaExistente) {
                              $fechasHoras[] = ['fecha' => $fecha->format('Y-m-d'), 'hora' => $hora];
                          }
                      }
                  }
              }



           return view('agendar', compact('pacientes', 'fechasHoras'));
          } else {
              // Proceso si los valores no son nulos
              // ...
              //CALCULAR FECHAS DE ACUERDO A FECHA NUMERO DE CITAS Y DIAS DE SEPARACION
              $agendas = Agenda::all();
              $pacientes = Paciente::all();

              $fechasHoras = [];

              for ($i = 0; $i < 10; $i++) {
                  $fecha = Carbon::now()->addDays($i);

                  // Omitir sábados y domingos
                  if ($fecha->isWeekday()) {
                      for ($j = 9; $j <= 16; $j++) {
                          $hora = $fecha->copy()->setTime($j, 0, 0)->format('H:i');

                          // Verificar que la fecha y hora no coincida con las agendas existentes
                          $horaCompleta = $hora . ':00';
                          $agendaExistente = $agendas->where('fecha', $fecha->format('Y-m-d'))
                              ->where('hora', $horaCompleta)
                              ->first();


                          if (!$agendaExistente) {
                              $fechasHoras[] = ['fecha' => $fecha->format('Y-m-d'), 'hora' => $hora];
                          }
                      }
                  }
              }

                $fecha = Carbon::now()->setTimezone('-05:00')->format('Y-m-d');
              $fechas = [];
              $horas = [];
              $diaSemana = [];
           for ($i = 0; $i < $numCitas; $i++) {

        //CORREGIR SIN CARBON NOW PARA QUE TOME LA ULTIMA FECHA
        //   $fecha = Carbon::now()->addDays($diasDiferencia);
          $fecha = Carbon::parse($fecha)->addDays($diasDiferencia)->format('Y-m-d');
          $esFinDeSemana = Carbon::parse($fecha)->isWeekend();
if ($esFinDeSemana) {
  $fecha = Carbon::parse($fecha)->addDays(1)->format('Y-m-d');
}
$esFinDeSemana = Carbon::parse($fecha)->isWeekend();
if ($esFinDeSemana) {
$fecha = Carbon::parse($fecha)->addDays(1)->format('Y-m-d');
}



             $fechas[$i] = $fecha;
             $diaSemana[$i] = Carbon::parse($fecha)->format('l');
             $diaSemana[$i] = __($diaSemana[$i]);

           foreach ($fechasHoras as $fechaHora) {
               $fechadas = $fechaHora['fecha'];
            //   $hora = $fechaHora['hora'];
//ARREGLAR Y COINCIDIR FORMATOS DE FECHA
               if ($fechadas === $fechas[$i]) {


            if (!isset($horas[$i]))   {
                $horas[$i] = $fechaHora['hora'];
              }



          /*    if (!isset($horas[$i])) {
                         $horas[$i] = $hora;
                     } else {
                         if ($hora < $horas[$i]) {
                             $horas[$i] = $hora;
                         }
                     } */

               }
           }

           }

           //GRABAR EN TABLA AGENDAS paciente fechas horas

           /*
           $agenda = new Agenda;
           $agenda->fecha = $fecha;
           $agenda->hora = $hora;
           $agenda->id_paciente = $id_paciente;
           $agenda->save();*/

           foreach ($fechas as $key => $fecha) {
    $hora = $horas[$key] ?? '17:00:00';

    $agenda = new Agenda;
    $agenda->fecha = $fecha;
    $agenda->hora = $hora;
    $agenda->id_paciente = $paciente;
    $agenda->save();
}

           return view('agendar', compact('numCitas','diasDiferencia', 'paciente','fechas','horas','diaSemana','agendaExistente'));
          }

          // Resto del código
          // ...

    }





public function asyncDatabaseQueries()
{
    return async(function () {
        $agendasPromise = async(function () {
            return Agenda::all();
        });

        $pacientesPromise = async(function () {
            return Paciente::all();
        });

        $agendas = await($agendasPromise);
        $pacientes = await($pacientesPromise);

        return [
            'agendas' => $agendas,
            'pacientes' => $pacientes,
        ];
    });
}


public function createAsyncAgenda($fecha, $hora, $paciente)
{
    return async(function () use ($fecha, $hora, $paciente) {
        $agenda = new Agenda;
        $agenda->fecha = $fecha;
        $agenda->hora = $hora;
        $agenda->id_paciente = $paciente;
        $agenda->save();
    });
}

public function asyncDatabaseQueries2()
{
    $agendasPromise = resolve(function () {
        return Agenda::all();
    });

    $pacientesPromise = resolve(function () {
        return Paciente::all();
    });

    return Promise::all([$agendasPromise, $pacientesPromise])->then(function ($results) {
        return [
            'agendas' => $results[0],
            'pacientes' => $results[1],
        ];
    });
}

public function createAsyncAgenda2($fecha, $hora, $paciente)
{
    return resolve(function () use ($fecha, $hora, $paciente) {
        $agenda = new Agenda;
        $agenda->fecha = $fecha;
        $agenda->hora = $hora;
        $agenda->id_paciente = $paciente;
        $agenda->save();
    });
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
