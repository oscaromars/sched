<a href="{{ route('agenda') }}" id="rd-id">AGENDA DIGITAL</a>
@if(isset($pacientes))
<form method="POST" action="{{ route('agendar') }}">
    @csrf
    <label for="paciente">Seleccionar paciente:</label>
    <select name="paciente" id="paciente">
        @foreach($pacientes as $paciente)
            <option value="{{ $paciente->id }}">{{ $paciente->Apellidos }}, {{ $paciente->Nombres }}</option>
        @endforeach
    </select>

    <label for="num_citas">Número de Citas Automáticas:</label>
   <input type="text" name="num_citas" id="num_citas">

   <label for="dias_diferencia">Número de Días de Diferencia:</label>
   <input type="text" name="dias_diferencia" id="dias_diferencia">

   <button type="submit">Generar</button>

</form>
@endif





@if (isset($fechas) && isset($horas))
    <ul>
        <h2>Citas agendadas</h2>
        @foreach($fechas as $key => $fecha)
            <li>{{ $fecha }} {{ $horas[$key] ?? '' }} </li>

        @endforeach
    </ul>
@endif


<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    /* Estilos para el formulario */
    form {
        width: 100%;
        max-width: 400px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #f9f9f9;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    select,
    input[type="text"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        width: 100%;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Estilos para las listas */
    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 5px;
    }

    /* Estilos para los encabezados */
    h2 {
        margin-top: 20px;
        margin-bottom: 10px;
    }

    #rd-id {
      background-color: #4CAF50;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      position:absolute;top:0px;
 }
</style>
