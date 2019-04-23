<?PHP require 'views/header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?PHP echo $this->title ; ?>
        <small><?PHP echo $this->subtitle ; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Panel de Administración</li>
      </ol>
    </section>

<?PHP
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'PDF'){
?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
                <li class="pull-left header"><i class="fa fa-inbox"></i> Asistencia</li>
                </ul>
                <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                </div>
            </div>
            </section>
            <section class="col-lg-6 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                <i class="ion ion-clipboard"></i>

                <h3 class="box-title">Documentos Recibidos</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="todo-list">
                    <li>
                        <!-- drag handle -->
                        <!--span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span-->
                        <!-- checkbox -->
                        <!--input type="checkbox" value=""-->
                        <!-- todo text -->
                        <span class="text">Material 1</span>
                        <!-- Emphasis label -->
                        <!--small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small-->
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <!-- drag handle -->
                        <!--span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span-->
                        <!-- checkbox -->
                        <!--input type="checkbox" value=""-->
                        <!-- todo text -->
                        <span class="text">Material 2</span>
                        <!-- Emphasis label -->
                        <!--small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small-->
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    
                </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>
        </div>
        
    </section>
<?PHP } ?>

<?PHP
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ALU'){
?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="ion ion-clipboard"></i>
                        <h3 class="box-title">Lista de compañeros</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="alumnos_tabla" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nombres</th>
                                    <th>Apellidos</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            
            </section>
            <section class="col-lg-6 connectedSortable">
            <!-- TO DO List -->
            <div class="box box-primary">
                <div class="box-header">
                <i class="ion ion-clipboard"></i>

                <h3 class="box-title">Documentos Recibidos</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                <ul class="todo-list">
                    <li>
                        <!-- drag handle -->
                        <!--span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span-->
                        <!-- checkbox -->
                        <!--input type="checkbox" value=""-->
                        <!-- todo text -->
                        <span class="text">Material 1</span>
                        <!-- Emphasis label -->
                        <!--small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small-->
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    <li>
                        <!-- drag handle -->
                        <!--span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span-->
                        <!-- checkbox -->
                        <!--input type="checkbox" value=""-->
                        <!-- todo text -->
                        <span class="text">Material 2</span>
                        <!-- Emphasis label -->
                        <!--small class="label label-danger"><i class="fa fa-clock-o"></i> 2 mins</small-->
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                        </div>
                    </li>
                    
                </ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix no-border">
                
                </div>
            </div>
            <!-- /.box -->
            </section>
        </div>
        
    </section>
<?PHP } ?>

<?PHP
    if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){
?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <section class="col-lg-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                    <h3 class="box-title">Alumnos por Grupos</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                    <div class="row">
                        <div class="col-md-8">
                        <div class="chart-responsive">
                            <canvas id="pieChart" height="150"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                        <ul id="lista_grupos" class="chart-legend clearfix">
                        </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked" id="grupo_porcentaje">
                        
                    </ul>
                    </div>
                    <!-- /.footer -->
                </div>
                <!-- /.box -->
            </section>
        </div>
    </section>
<?PHP } ?>
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<!-- jQuery UI 1.11.4 -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/bower_components/moment/moment.js"></script>
<!-- Morris.js charts -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/raphael/raphael.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?PHP echo constant('URL'); ?>views/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?PHP echo constant('URL'); ?>views/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- Slimscroll -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="<?PHP echo constant('URL'); ?>views/bower_components/chart.js/Chart.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>


<?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){ ?>
<script src="<?PHP echo constant('URL'); ?>views/dist/js/pages/dashboard_admin.js"></script>
<?PHP } ?>

<script>
    var grupos = "";
    var alumnos = "";
    $(document).ready(function() {
        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){ ?>
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>grupo/GetCantidadAlumnoxGrupo", 
                success: function(result){
                    grupos = JSON.parse(result);
                    console.log(grupos);
                    MuestraGruposCantidad(grupos);
                },
                error:function(result){
                    console.log(result);
                },
                complete: function() {
                    //setInterval(GetInfoPanel(tipo, div), 5000); 
                }
            });
        <?PHP } ?>

        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ALU'){ ?>
            var idgrupo = "";
            var info            = {};
            info["usuario"]     = '<?PHP echo($_SESSION['usuario']); ?>';
            var myJsonString    = JSON.stringify(info);
            console.log(myJsonString);
            
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>grupo/GetGrupoID", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    idgrupo     = JSON.parse(result);
                    var info    = {};
                    info["grupo"]     = idgrupo;
                    var myJsonString    = JSON.stringify(info);
                    console.log(myJsonString);
                    alumnos = $('#alumnos_tabla').DataTable( {
                        "ajax": {
                            "type": "POST",
                            "url": "<?PHP echo constant('URL'); ?>alumno/GetAlumnosByGrupo",
                            "data": {
                                "datos": myJsonString
                            },
                            "error": function (jqXHR, textStatus, errorThrown) {
                                console.log("sss");
                            }
                        },
                        "responsive":true,
                        "scrollX":        false,
                        "scrollCollapse": true,
                        "ordering": false,
                        "bLengthChange": false,
                        "pageLength": 5,
                        "bDestroy": true,
                        "fixedColumns":   {
                            "leftColumns": 2
                        },
                        "language":{
                            "url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                        },
                        "columnDefs":[
                            {
                                "targets":0,
                                "data":"nombres",
                                "width":"15%"
                            },
                            {
                                "targets":1,
                                "data":"apellidos",
                                "width":"15%"
                            },
                            {
                                "targets":2,
                                "data":"correo",
                                "width":"15%"
                            },
                            {
                                "targets":3,
                                "data":"celular",
                                "width":"15%"
                            }
                        ]
                        
                    } );
                },
                error:function(result){
                    console.log(result);
                },
                complete: function() {
                    //setInterval(GetInfoPanel(tipo, div), 5000); 
                }
            });

            
        <?PHP } ?>
    });

    function MuestraGruposCantidad(data)
    {
        var color = [];
        var label = [];
        var value = [];
        var li = "";
        var li_porcentaje = "";

        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };

        for (var i in data) {
            if(data[i].color==""){
                data[i].color = dynamicColors();
                li += '<li><i class="fa fa-circle-o" style="color:'+ data[i].color +'"></i> '+ data[i].label +'</li>';       
                li_porcentaje += '<li><a href="#">'+ data[i].label +'<span class="pull-right" style="color:'+ data[i].color +'"> '+ data[i].porce +'%</span></a></li>';
            }
        }
        var ul = $("#lista_grupos");
        ul.html(li);

        var ul_porce = $("#grupo_porcentaje");
        ul_porce.html(li_porcentaje);
        
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var pieChart       = new Chart(pieChartCanvas);
        var PieData         = data;
        
        var pieOptions     = {
            // Boolean - Whether we should show a stroke on each segment
            segmentShowStroke    : true,
            // String - The colour of each segment stroke
            segmentStrokeColor   : '#fff',
            // Number - The width of each segment stroke
            segmentStrokeWidth   : 1,
            // Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 50, // This is 0 for Pie charts
            // Number - Amount of animation steps
            animationSteps       : 100,
            // String - Animation easing effect
            animationEasing      : 'easeOutBounce',
            // Boolean - Whether we animate the rotation of the Doughnut
            animateRotate        : true,
            // Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale         : false,
            // Boolean - whether to make the chart responsive to window resizing
            responsive           : true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio  : false,
            // String - A legend template
            legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            // String - A tooltip template
            tooltipTemplate      : '<%=label%> - <%=value %> alumnos',
            title: {
					display: true,
					text: 'Chart.js Doughnut Chart'
				},
        };
        // Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
    }
</script>