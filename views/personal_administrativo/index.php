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
                <li><a href="#">Intranet</a></li>
                <li class="active">Listado de Registros</li>
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
                        <h3 class="box-title"><?PHP echo $this->subtitle ; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="confirm_data" class="alert alert-success alert-dismissible" style="display:none;">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                                <span id="mensaje_confirmacion_data"></span>
                            </div>

                            <table id="personal_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

   
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>

<script>
    $(document).ready(function(){
        var personal = $('#personal_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>personal_administrativo/ListaPersonalAdm",
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
			        "targets": 0,
                    "data":"idtipo",
                    "render": function(url, type, full){
                        var tipo = full["idtipo"];
                        if(tipo == "ADM"){
                            return "Administrativo";
                        }

                        if(tipo == "DOC"){
                            return "Docente";
                        }
                    }
			    },
                {
			        "targets": 1,
                    "data":"nombres"
			    },
                {
			        "targets": 2,
                    "data":"apellidos"
			    },
                {
			        "targets": 3,
                    "data":"correo"
			    }        
			],
			"dom": 'Bfrtip',
			"buttons": [
                {
					"extend": "pdfHtml5",
					"orientation": "landscape",
					"pageSize": "LEGAL"
                }
			]
		} );
    });
</script>