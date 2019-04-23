<?PHP require 'views/header.php'; ?>

<style>
.modal-dialog{
    overflow-y: initial !important
}
.extrab{
    height: 450px;
    overflow-y: auto;
}
</style>

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
        <li><a href="#">Reportes</a></li>
        <li class="active">Reporte de Audiciones 2019</li>
      </ol>
    </section>

    <!-- Delete Modal -->
    <div class="modal modal-danger fade" id="modal_delete">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">¿Eliminar Registro?</h4>
            </div>
            <div class="modal-body">
            <p>¿Desea eliminar el registro?</p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
            <button type="button" id="btn_elimina" data-placa="" data-value="" class="btn btn-outline">Eliminar</button>
            </div>
        </div>
        </div>
    </div>
    <!-- End Delete Modal -->

    <!-- Div Nuevo Docente -->
    <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><span id="modal_title_fotos">Nuevo Docente</span></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_docente" method="POST">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="txt_nombres">Nombres</label>
                                    <input required type="text" class="form-control" id="txt_nombres" name="txt_nombres" >
                                </div>
                                <div class="col-md-6">
                                    <label for="txt_apellidos">Apellidos</label>
                                    <input required type="text" class="form-control" id="txt_apellidos" name="txt_apellidos" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="txt_correo">Correo</label>
                                    <input required type="text" class="form-control" id="txt_correo" name="txt_correo" >
                                </div>
                                <div class="col-md-4">
                                    <label for="txt_celular">Celular</label>
                                    <input required type="text" class="form-control" id="txt_celular" name="txt_celular" >
                                </div>
                                <div class="col-md-4">
                                    <label for="txt_dni">DNI</label>
                                    <input required type="text" class="form-control" id="txt_dni" name="txt_dni" >
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" data-value="0" id="btn_enviar" name="btn_enviar" class="btn btn-primary">Registrar</button>
                    </div>              
                    </form>
                </div>
            </div>
        </div>
        <!-- End Div Nuevo Docente -->



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

                            <table id="docente_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Correo</th>
                                        <th>Celular</th>
                                        <th>DNI</th>
                                        <th>Opciones</th>
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/b-1.5.4/b-html5-1.5.4/r-2.2.2/datatables.min.js"></script>


<script>
    var docentes = "";
    var fotos = "";
    $(document).ready(function() {
        
        docentes = $('#docente_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>docente/GetDocentes",
			"responsive":true,
			"scrollX":        false,
			"scrollCollapse": true,
            "ordering": false,
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
                },
                {
                    "targets":4,
                    "data":"dni",
                    "width":"15%"
                },
                {
                    "targets":5,
                    "data":"iddocente",
                    "render": function(url, type, full){
                        var id          = "'" + full[0] + "'";
                        return '<button onclick="ver_docente('+ id +');" title="Ver docente" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button onclick="alert_elimina('+ id +');" title="Eliminar docente" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
                        return false;
                    },
                    "width":"15%"
                }
            ],
			"dom": 'Bfrtip',
			"buttons": [
				{
                    text: 'Nuevo',
					action: function ( e, dt, node, config ) {
                        $("#md_nuevo").modal();    
                        $("#txt_nombres").val("");
                        $("#txt_apellidos").val("");
                        $("#txt_correo").val("");
                        $("#txt_celular").val("");
                        $("#txt_dni").val("");
                        $("#txt_nombres").focus();
                        $("#btn_enviar").attr("data-value", "0");
                        $("#btn_enviar").html("Registrar");
                        console.log("nuevo");
					}
                }
			]
        } );

        $("#frm_docente").submit(function(event){
            event.preventDefault();
            var url         = "";
            var id          = $("#btn_enviar").attr("data-value");
            var nombres     = $("#txt_nombres").val();
            var apellidos   = $("#txt_apellidos").val();
            var correo      = $("#txt_correo").val();
            var celular     = $("#txt_celular").val();
            var dni         = $("#txt_dni").val();
            var info        = {};
            url             = "<?PHP echo constant('URL'); ?>docente/RegistraDocente";
            
            if(id!="0"){
                info["id"]      = id;
                url             = "<?PHP echo constant('URL'); ?>docente/ActualizaDocente";
            }
            info["nombres"]     = nombres;
            info["apellidos"]   = apellidos;
            info["correo"]      = correo;
            info["celular"]     = celular;
            info["dni"]         = dni;
            var myJsonString    = JSON.stringify(info);
            console.log(url);
            
            $.ajax({
                type: "POST",
                url: url, 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $("#confirm_data").show().delay(2000).fadeOut();
                    $("#mensaje_confirmacion_data").html('Se ha registrado un nuevo docente');
                    $("#md_nuevo").modal('hide');
                    docentes.ajax.reload();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });
        
        $("#btn_elimina").click(function(){
            var id = $("#btn_elimina").attr("data-value");
            var info            = {};
            info["id"]          = id;
            var myJsonString    = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>docente/EliminaDocente", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#modal_delete').modal('hide');
                    docentes.ajax.reload();
                },
                error:function(result){
                    console.log("error"+result);
                }
            });
        });
        
    });

    function alert_elimina(id){
        $("#modal_delete").modal();
        $("#btn_elimina").attr("data-value", id);
        
    }

    function ver_docente(id)
    {
        $("#md_nuevo").modal();        
        $("#btn_enviar").html("Actualizar");
        $("#btn_enviar").attr("data-value", id);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>docente/VerDocente", 
            data:{
                datos: '{"id": "' + id + '"}'
            },
            success: function(result){
                var datos = jQuery.parseJSON(result);
                $("#txt_nombres").val(datos[0].nombres);
                $("#txt_apellidos").val(datos[0].apellidos);
                $("#txt_correo").val(datos[0].correo);
                $("#txt_celular").val(datos[0].celular);
                $("#txt_dni").val(datos[0].dni);
                console.log(datos[0]);
            },
            error:function(result){
                console.log(result);
            }
        });
    }

</script>