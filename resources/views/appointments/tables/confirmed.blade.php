<div class="table-responsive">
  <table class="table align-items-center table-flush">
    <thead class="thead-light">
      <tr>
        <th scope="col">Descripción</th>
        <th scope="col">Especialidad</th>
        @if( $role == 'patient' )
          <th scope="col">Medico</th>
        @elseif( $role == 'doctor' )
          <th scope="col">Paciente</th>
        @endif
        <th scope="col">Fecha</th>
        <th scope="col">Hora</th>
        <th scope="col">Tipo</th>
        <th scope="col">Opciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach( $confirmedAppointments as $appointment )
      <tr>
        <th scope="row">
          {{ $appointment->description }}
        </th>
        <td>
          {{ $appointment->specialty->name }}
        </td>
        @if( $role == 'patient' )
          <td>
            {{ $appointment->doctor->name }}
          </td>
        @elseif( $role == 'doctor' )
          <td>
            {{ $appointment->patient->name }}
          </td>
        @endif
        <td>
          {{ $appointment->scheduled_date }}
        </td>
        <td>
          {{ $appointment->scheduled_time_12 }}
        </td>
        <td>
          {{ $appointment->type }}
        </td>
        <td>
          @if( $role== 'admin' )
            <a href="{{ url('/appointments/'.$appointment->id) }}" class="btn btn-sm btn-primary" title="Ver cita">
              Ver
            </a>
          @endif
          <a href="{{ url('/appointments/'.$appointment->id.'/cancel') }}" class="btn btn-sm btn-danger" title="Cancelar cita">
            Cancelar
          </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="card-footer py-4">
  {{ $confirmedAppointments->links() }}
</div>
