@extends('layouts.admin')

@section('bar-title', 'Home')
@section('header-title', 'Home')
@section('content')
<div class="row">
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
            <h3>{{ $totalMember }}</h3>

            <p>Total Member</p>
            </div>
            <div class="icon">
            <i class="fa fa-user-tie"></i>
            </div>
            <a href="{{ url('members') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $totalSupplier }}</h3>

            <p>Total Supplier</p>
            </div>
            <div class="icon">
            <i class="fa fa-users"></i>
            </div>
            <a href="{{ url('suppliers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
            <h3>{{ $totalItem }}</h3>

            <p>Total Item</p>
            </div>
            <div class="icon">
            <i class="fa fa-cookie-bite"></i>
            </div>
            <a href="{{ url('suppliers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
            <h3>{{ $totalTransaction }}</h3>

            <p>Total Transaction</p>
            </div>
            <div class="icon">
            <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="{{ url('transactions') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
    </div>
        <!-- ./col -->
   
    <!-- /.row -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
            <h3 class="card-title">Transaction Chart</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
            <div class="chart">
                <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
<script>

    var data_line = '{!! json_encode($data_line) !!}';

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: JSON.parse(data_line)
    }
    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })
</script>
@endsection