{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    {{-- Dashboard 1 --}}
 
        <div class="example-preview">
           
            <div class="row">
                <div class="col-lg-12">
                    
                    <figure class="highcharts-figure">
                        <div id="quick_count" style="height:500px"></div>
                    </figure>
                  
                </div>

            </div>
            
        </div>

@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
       var category = <?php echo $kategori;?>;
       var total_suara = <?php echo $total_suara;?>;

        $(document).ready(function() {
            $('.select2').select2();

        Highcharts.chart('quick_count', {
            chart: {
                type: 'column',
                //backgroundColor:'black'
            },
            title: {
                text: 'Perolehan Suara'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: category,
                crosshair: true
            },
            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Jumlah'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f} suara</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            // plotOptions: {
            //     column: {
            //         pointPadding: 0.2,
            //         borderWidth: 0
            //     }
            // },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.0f} ',
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                showInLegend: false, 
                color: {
                    linearGradient: [100, 200, 0, 0],
                    stops: [
                        [0.1, '#ff5d5d'],
                        [0.325, '#ff9d33']
                    ]
                },
                name: '',
                data: total_suara

            }, ]
        });


           

        });
    </script>
   
@endsection
