<?php 
  $item = null;
  $valor = null;
  $orden = 'sales';
  $productos = ControladorProductos::ctrMostrarProductos($item,$valor,$orden);
  $colores = array('danger','primary','secondary','success','dark','danger','info','warning','default','success');
  $colores2= array('#dc3545','#007bff','#6c757d','#28a745','#343a40','#dc3545','#17a2b8','#ffc107','#6c757d','#28a745');
  $totalVentas = ControladorProductos::ctrMostrarSumaVentas();
 ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Productos más vendidos</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
      </button>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="row">
      <div class="col-md-8">
        <div class="chart-responsive">
          <canvas id="pieChart" height="150"></canvas>
        </div>
        <!-- ./chart-responsive -->
      </div>
      <!-- /.col -->
      <div class="col-md-4">
        <ul class="chart-legend clearfix">
          <?php 
          if (count($productos <10)) {
            $tope = count($productos);
          }else{
            $tope = 10;
          }
            for ($i=0; $i < $tope ; $i++) { 
              echo  '<li><i class="far fa-circle text-'.$colores[$i].'"></i>'.$productos[$i]['name'].'</li>';
            }
           ?>
        </ul>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.card-body -->
  <div class="card-footer bg-white p-0">
    <ul class="nav nav-pills flex-column">
      <?php 
      if (count($productos <5)) {
            $tope2 = count($productos);
          }else{
            $tope2 = 5;
          }
        for ($i=0; $i < $tope2; $i++) { 
          echo '<li class="nav-item"><a href="#" class="nav-link">
          '.$productos[$i]['name'].'
          <span class="float-right text-'.$colores[$i].'"><i class="fa fa-arrow-down text-sm"></i>';
          $porcentaje = $productos[$i]['sales']/$totalVentas['total'] * 100;
          echo ceil($porcentaje).'
          </span></a></li>';
        }
       ?>
    </ul>
  </div>
  <!-- /.footer -->
</div>
<!-- /.card -->
<script>
//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      <?php 
        for ($i=0; $i < $tope ; $i++) { 
          echo "{
          value    : ".$productos[$i]['sales'].",
          color    : '".$colores2[$i]."',
          highlight: '".$colores2[$i]."',
          label    : '".$productos[$i]['name']."'
          },";
        }
       ?>
      
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)
  </script>