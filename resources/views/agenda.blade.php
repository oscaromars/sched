<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/main.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core/locales/es.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        /* Estilos generales */
        body {
            font-family: verdana;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f9f9f9;
        }

        /* Estilos para el contenedor del calendario */
        h3 {
            text-align: center;
        }

        #calendar {
            width: 100%;
            max-width: 1200px;
            margin-bottom: 20px;
        }

        /* Estilos para los eventos del calendario */
        .fc-event {
            background-color: #f2f2f2;
            border-color: #ccc;
            color: #333;
        }

        /* Estilos para los días y encabezados del calendario */
        .fc-day-header {
            background-color: #ddd;
            font-weight: bold;
        }

        .mi-evento {
            background-color: #ffffff;
            color: #333;
            font-weight: bold;
            height: 50px;
        }

        .fc-event-title {
            white-space: normal;
            word-break: break-word;
            width: auto !important;
            max-width: 100%;
        }

        .event-title {
            white-space: normal;
            word-break: break-word;
        }
        .fc-today {
       background-color: #336699;
       color: #fff;
       font-weight: bold;
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
</head>
<body>
<h3>Agenda de Citas Medicas</h3>
<a href="{{ route('agendar') }}" id="rd-id">AGENDAR CITA</a>


<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date();

        function getNextSunday(date) {
            var nextSunday = new Date(date);
            nextSunday.setDate(date.getDate() + ((7 - date.getDay() + 1) % 7) + 98);
            return nextSunday;
        }

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            height: '500px',
            timeFormat: 'HH:mm',
            initialView: 'dayGridWeek',
            hiddenDays: [0, 6],
            dayHeaderFormat: { weekday: "long", month: "long", day: "numeric" },
            eventContent: function(arg) {
                return {
                    html: "<span>" + arg.timeText + "H00 <br>" + arg.event.title + "</span>",
                };
            },
            eventClassNames: 'mi-evento',
            buttonText: {
                today: 'Fecha Actual'
            },

            validRange: {
            start: today,
            end: getNextSunday(today),
            },
            events: [

              @if (isset($agendas))
      @foreach($agendas as $evento)
          @php
              $paciente = $pacientes->find($evento['id_paciente']);
              $titulo = $paciente ? $paciente->Apellidos . ' ' . $paciente->Nombres : '';
          @endphp

          {
              title: "{{ $titulo }}",
              start: "{{ $evento['fecha'] }}T{{ $evento['hora'] }}",
              end: "{{ $evento['fecha'] }}T{{ $evento['hora'] }}",
          },
      @endforeach
  @endif


            ]
            });
            calendar.render();
});

</script>
</body>
</html>
