@extends('layouts.panel')

@section('content')
<div class="card shadow">
  <div class="card-header border-0">
    <div class="row align-items-center">
      <div class="col">
        <h3 class="mb-0">Reporte: Médicos más activos</h3>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="input-daterange datepicker row align-items-center" 
            data-date-format="yyyy-mm-dd">
        <div class="col">
            <div class="form-group">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control" id="startDate"
                        placeholder="Fecha de inicio" type="text" value="{{ $start }}">
                </div>
            </div>
        </div>
        <div class="col">
            <div class="form-group">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                    </div>
                    <input class="form-control" id="endDate"
                        placeholder="Fecha de fin" type="text" value="{{ $end }}">
                </div>
            </div>
        </div>
    </div>

    <div id="container"> </div>
  </div>


</div>
@endsection

@section('scripts')
    <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script>
        const chart = Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Médicos más activos'
            },
            xAxis: {
                categories: [
                ],
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Citas atendidas'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            series: []
        });

    let $start, $end;

        function fetchData() {
            const startDate = $start.val();
            const endDate = $end.val();

            const url = `/charts/doctors/column/data?start=${startDate}&end=${endDate}`;
            // Fetch API
            fetch(url)
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    //console.log(myJson);
                    chart.xAxis[0].setCategories(data.categories);
                    if( chart.series.length > 0 ){
                        chart.series[1].remove();
                        chart.series[0].remove();
                    }
                    chart.addSeries(data.series[0]);
                    chart.addSeries(data.series[1]);
                }); 
        }

        $(function(){
            $start = $('#startDate');
            $end = $('#endDate');
            fetchData();
           
            $start.change(fetchData);
            $end.change(fetchData);
        });
    </script>
@endsection