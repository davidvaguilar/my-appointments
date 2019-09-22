@extends('layouts.panel')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Registrar nuevas citas</h3>
      </div>
      <div class="col text-right">
        <a href="{{ url('patients')}}" class="btn btn-sm btn-default">
          Cancelar y volver
        </a>
      </div>
    </div>
  </div>

  <div class="card-body">
    @if( $errors->any() )
      <div class="alert alert-danger" role="alert">
        <ul>
          @foreach( $errors->all() as $error )
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <form action="{{ url('appointments') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="description">Descripción</label>
        <input name="description" id="description" value="{{ old('description') }}" type="text" class="form-control" placeholder="Describe brevemente la consulta" required>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="specialty">Especialidad</label>
          <select name="specialty_id" id="specialty" class="form-control" required>
            <option value="">Seleccionar especialidad</option>
            @foreach( $specialties as $specialty )
              <option value="{{ $specialty->id }}" @if( old('specialty_id') == $specialty->id ) selected @endif>{{ $specialty->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="doctor">Médico</label>
          <select name="doctor_id" id="doctor" class="form-control" required>

            @foreach( $doctors as $doctor )
              <option value="{{ $doctor->id }}" @if( old('doctor_id') == $doctor->id ) selected @endif>{{ $doctor->name }}</option>
            @endforeach

          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="dni">Fecha</label>
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
             <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
          </div>
          <input class="form-control datepicker" placeholder="Seleccionar fecha" type="text"
                  id="date" name="scheduled_date"
                  value="{{ old('scheduled_date', date('Y-m-d')) }}"
                  data-date-format="yyyy-mm-dd"
                  data-date-start-date="{{ date('Y-m-d') }}"
                  data-date-end-date="+30d">
        </div>
      </div>

      <div class="form-group">
        <label for="address">Hora de atencion</label>
        <div id="hours">
          @if( $intervals )
            @foreach( $intervals['morning'] as $key => $interval )
              <div class="custom-control custom-radio mb-3">
                <input name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
              </div>
            @endforeach
            @foreach( $intervals['afternoon'] as $interval )
              <div class="custom-control custom-radio mb-3">
                <input name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input" id="intervalMorning{{ $key }}" type="radio" required>
                <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
              </div>
            @endforeach
          @else
            <div class="alert alert-info" role="alert">
              Seleccion un medio y una fecha, para ver sus horas disponibles.
            </div>
          @endif
        </div>
      </div>
      <div class="form-group">
        <label for="type">Tipo de consulta</label>
        <div class="custom-control custom-radio mb-3">
          <input name="type" class="custom-control-input" id="type1" type="radio"
              @if( old('type', 'Consulta') == 'Consulta' ) checked @endif value="Consulta">
          <label class="custom-control-label" for="type1">Consulta</label>
        </div>
        <div class="custom-control custom-radio mb-3">
          <input name="type" class="custom-control-input" id="type2"  type="radio"
              @if( old('type') == 'Examen' ) checked @endif value="Examen">
          <label class="custom-control-label" for="type2">Examen</label>
        </div>
        <div class="custom-control custom-radio mb-3">
          <input name="type" class="custom-control-input" id="type3"  type="radio"
              @if( old('type') == 'Operación' ) checked @endif value="Operación">
          <label class="custom-control-label" for="type3">Operación</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary"> Guardar </button>
    </form>
  </div>
</div>

@endsection

@section('scripts')
  <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
    let $doctor, $date, $specialty, $hours;
    let iRadio;
    const noHoursAlert = `<div class="alert alert-danger" role="alert">
        <strong>Lo sentimos!</strong> No se encontraron horas disponibles para el medico en el dia seleccionado.
      </div>`;

    $(function() {
      $specialty = $('#specialty');
      $doctor = $('#doctor');
      $date = $('#date');
      $hours = $('#hours');

      $specialty.change(() => {
        const specialtyId = $specialty.val();
        const url =  `/specialties/${specialtyId}/doctors`;
        $.getJSON(url, onDoctorsLoaded);
      });

      $doctor.change(loadHours);
      $date.change(loadHours);
    });

    function onDoctorsLoaded(doctors){
      let htmlOptions = '';
      doctors.forEach(doctor => {
        htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
      });
      $doctor.html(htmlOptions);
      loadHours();  //side-effect
    }

    function loadHours(){
      const selectedDate = $date.val();
      const doctorId = $doctor.val();
      const url = `/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
      $.getJSON(url, displayHours);
    }

    function displayHours(data){
      if( !data.morning && !data.afternoon ){
        $hours.html(noHoursAlert);
        return;
      }
      let htmlHours = '';
      iRadio = 0;
      if( data.morning ){
        const morning_intervals = data.morning;
        morning_intervals.forEach(interval => {
          htmlHours += getRadioIntervalHtml(interval);
          //console.log(`${interval.start} - ${interval.end}`);
        });
      }
      if( data.afternoon ){
        const afternoon_intervals = data.afternoon;
        afternoon_intervals.forEach(interval => {
          htmlHours += getRadioIntervalHtml(interval);
          //console.log(`${interval.start} - ${interval.end}`);
        });
      }
      $hours.html(htmlHours);
    }

    function getRadioIntervalHtml(interval) {
      const text = `${interval.start} - ${interval.end}`;
      return `<div class="custom-control custom-radio mb-3">
          <input name="scheduled_time" value="${interval.start}" class="custom-control-input" id="interval${iRadio}" type="radio">
          <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
        </div>`;
    }

  </script>
@endsection
