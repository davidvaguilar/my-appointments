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
    <form action="{{ url('/patients') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="specialty">Especialidad</label>
        <select name="specialty_id" id="specialty" class="form-control" required>
          <option value="">Seleccionar especialidad</option>
          @foreach( $specialties as $specialty )
            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="doctor">Médico</label>
        <select name="doctor_id" id="doctor" class="form-control">

        </select>
      </div>
      <div class="form-group">
        <label for="dni">Fecha</label>
        <div class="input-group input-group-alternative">
          <div class="input-group-prepend">
             <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
          </div>
          <input class="form-control datepicker" placeholder="Seleccionar fecha" type="text" id="date"
                  value="{{ date('Y-m-d') }}"
                  data-date-format="yyyy-mm-dd"
                  data-date-start-date="{{ date('Y-m-d') }}"
                  data-date-end-date="+30d">
        </div>
      </div>

      <div class="form-group">
        <label for="address">Hora de atencion</label>
        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
      </div>
      <div class="form-group">
        <label for="phone">Telefono / movil</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
      </div>

      <button type="submit" class="btn btn-primary"> Guardar </button>

    </form>
  </div>
</div>

@endsection

@section('scripts')
  <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
    let $doctor, $date, $specialty;

    $(function() {
      $specialty = $('#specialty');
      $doctor = $('#doctor');
      $date = $('#date');

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
      loadHours()
    }

    function loadHours(){
      const selectedDate = $date.val();
      const doctorId = $doctor.val();
      const url = `/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
      $.getJSON(url, displayHours);
    }

    function displayHours(data){
      if( data.morning ){
        const morning_intervals =data.morning;
        morning_intervals.forEach(interval => {
          console.log(`${interval.start} - ${interval.end}`);
        });
      }
      if( data.afternoon ){
        const afternoon_intervals =data.afternoon;
        afternoon_intervals.forEach(interval => {
          console.log(`${interval.start} - ${interval.end}`);
        });
      }
    }

  </script>
@endsection
