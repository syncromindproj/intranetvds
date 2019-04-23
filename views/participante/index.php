<?PHP require 'views/header.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Participantes
        <small>Listado de Participantes</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Reportes</a></li>
        <li class="active">Reporte de Audiciones 2019</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                <h3 class="box-title">Audiciones 2019</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="participantes" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>¿Aprobado?</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Correo Postulante</th>
                                <th>Celular Postulante</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Edad</th>
                                <th>Distrito</th>
                                <th>Centro de Estudios</th>
                                <th>Año de Estudios</th>
                                <th>Nombre de Apoderado</th>
                                <th>Celular Apoderado</th>
                                <th>Correo Apoderado</th>
                            </tr>
                        </thead>
                    </table>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<style>
     .selected{
         background-color:#acbad4 !important;
     }
 </style>
<script>
	$(document).ready(function() {
		var selected = [];
		var participantes = $('#participantes').DataTable( {
		  "ajax": "<?PHP echo constant('URL'); ?>participante/getParticipantes",
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
			"fixedColumns":   {
				"leftColumns": 2
			},
			"language":{
				"url":"https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
			},
			"columnDefs":[
			    {
			        "targets": [3],
                    "visible": false,
			    },
			    {
			        "targets": [4],
                    "orderable": false,
			    },
			    {
			        "targets": [5],
                    "orderable": false,
			    }      
			],
			"columns":[
				{"data":"aprobado"},
				{"data":"nombres"},
				{"data":"apellidos"},
				{"data": "fecha"},
				{"data": "fecha2"},
				{"data":"hora"},
				{"data":"correo_postulante"},
				{"data":"celular_postulante"},
				{"data":"fecha_nacimiento"},
				{"data":"edad"},
				{"data":"distrito"},
				{"data":"centro_estudios"},
				{"data":"anio_estudios"},
				{"data":"nombre_apoderado"},
				{"data":"celular_apoderado"},
				{"data":"correo_apoderado"}
			],
			"rowCallback": function( row, data ) {
				if ( $.inArray(data.idparticipante, selected) !== -1 ) {
					$(row).addClass('selected');
				}
			},
			"dom": 'Bfrtip',
			"buttons": [
				{
					"extend": "pdfHtml5",
					"orientation": "landscape",
					"pageSize": "LEGAL"
				},
				{
					text: 'Aprobar',
					action: function ( e, dt, node, config ) {
						$.ajax({
							type: "POST",
							url: "<?PHP echo constant('URL'); ?>participante/Aprobar", 
							data:{
								data: selected
							},
							success: function(result){
								if(result != ""){
									alert("Se aprobaron " +  result + " participantes.");
									selected = [];
									participantes.ajax.reload();	
								}else{
									alert("Seleccione por lo menos un participante.");
								}
							},
							error:function(result){
								console.log(result);
							}
						});
					}
				}
			]
		} );
		
		$('#participantes tbody').on('click', 'tr', function () {
			var id = this.id;
			
			var index = $.inArray(id, selected);
	 
			if ( index === -1 ) {
				selected.push( id );
			} else {
				selected.splice( index, 1 );
			}
			console.log(selected);
			$(this).toggleClass('selected');
		} );
		
		
	} );
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
     </body>
</html>