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
                <li><a href="#">E-taller</a></li>
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

                            <table id="horario_tabla" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Grupo</th>
                                        <th>Horario</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="md_nuevo" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_title"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_horario" method="POST">
                            <div class="form-row">
                                <div class="col-4">
                                    <label for="sl_grupo">Grupo</label>
                                    <select id="sl_grupo" class="form-control" required></select>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label for="txt_descripcion">Descripción</label>
                                    <input required type="text" class="form-control" id="txt_descripcion" name="txt_descripcion" placeholder="Descripción">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btn_enviar" name="btn_enviar" class="btn btn-primary">Registrar</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>

            <div id="md_asignar" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal_title_asignar"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="frm_asignar" method="POST">
                            <div class="form-row">
                                <div class="col-4">
                                    <label for="sl_dia">Día</label>
                                    <select required id="sl_dia" class="form-control" required>
                                        <option value="">Seleccione un día</option>
                                        <option value="1">Lunes</option>
                                        <option value="2">Martes</option>
                                        <option value="3">Miercoles</option>
                                        <option value="4">Jueves</option>
                                        <option value="5">Viernes</option>
                                        <option value="6">Sábado</option>
                                        <option value="7">Domingo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label for="sl_horainicio">Hora Inicio</label>
                                    <select class="form-control" required name="sl_horainicio" id="sl_horainicio">
                                        <option value="">Elija el horario inicial</option>
                                        <?PHP
                                            for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
                                            for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
                                                echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                               .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <div class="col-4">
                                    <label for="sl_horafinal">Hora Final</label>
                                    <select class="form-control" required name="sl_horafinal" id="sl_horafinal">
                                        <option value="">Elija el horario Final</option>
                                        <?PHP
                                            for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
                                            for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
                                                echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
                                                               .str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row" style="margin-top:20px;">
                                <table id="horario_detalle_tabla" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Dia</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora Final</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="btn_registrar" data-value="" name="btn_registrar" class="btn btn-primary">Registrar</button>
                    </div>
                    </form>
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
    var horarios        = "";
    var horario_detalle = "";

    $(document).ready(function() {
        var idgrupo = "";
        var opcion = "";
        cargaGrupos();

        horarios = $('#horario_tabla').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>horario/GetHorarios",
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
			        "targets": [0],
                    "data":"grupo"
			    },
                {
			        "targets": [1],
                    "data":"descripcion"
			    },
                {
                    "targets": [2],
                    "data":"idhorario",
                    "render": function(url, type, full){
                        var idhorario = full[0];
                        return '<button type="button" onclick="asignar_grupo('+ idhorario +');" class="btn btn-warning"><i class="fa fa-plus-square"></i> Registrar Horas</button> '
                        return false;
                    }
                }        
			],
			"columns":[
				
			],
			"dom": 'Bfrtip',
			"buttons": [
				{
                    text: 'Nuevo',
					action: function ( e, dt, node, config ) {
                        opcion = "nuevo";
                        $('#md_nuevo').modal();
                        $("#modal_title").html("Nuevo Horario");
                        $("#btn_enviar").text("Guardar");
                        $("#txt_descripcion").val("");
                        $("#txt_descripcion").focus();
					}
                }
			]
		} );

        $("#frm_horario").submit(function(event){
            event.preventDefault();
            var idgrupo     = $("#sl_grupo").val();
            var descripcion = $("#txt_descripcion").val();
            var info = {};
            info["idgrupo"]     = idgrupo;
            info["descripcion"] = descripcion;
            var myJsonString = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>horario/InsertaHorario", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $('#md_nuevo').modal('hide');
                    horarios.ajax.reload();	
                    $("#mensaje_confirmacion").html("Se ha registrado el nuevo grupo.");
                    $("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });

        $("#frm_asignar").submit(function(event){
            event.preventDefault();
            var idhorario       = $("#btn_registrar").attr("data-value");
            var dia             = $("#sl_dia").val();
            var hora_inicio     = $("#sl_horainicio").val();
            var hora_final      = $("#sl_horafinal").val();
            var info            = {};
            info["idhorario"]   = idhorario;
            info["dia"]         = dia;
            info["hora_inicio"] = hora_inicio;
            info["hora_final"]  = hora_final;
            var myJsonString    = JSON.stringify(info);
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>horario/AsignarHorario", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    //$('#md_asignar').modal('hide');
                    $('#sl_dia').val('');
                    $('#sl_horainicio').val('');
                    $('#sl_horafinal').val('');
                    horario_detalle.ajax.reload();
                },
                error:function(result){
                    console.log(result);
                }
            });
        
        });

        
    });

    function cargaGrupos()
    {
        $("#sl_grupo").empty();
        $("#sl_grupo").append('<option value="" selected="selected">Seleccione un grupo</option>');
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?PHP echo constant('URL'); ?>grupo/getGrupos", 
            success: function(result){
                $.each(result.data, function(i,v){
                    var idgrupo     = v.idgrupo;
                    var descripcion = v.descripcion;
                    $("#sl_grupo").append('<option value="' + idgrupo +'">'+ descripcion +'</option>');
                });
            }
        });
    }

    function asignar_grupo(id)
    {
        $("#md_asignar").modal();
        $("#btn_registrar").attr("data-value", id);
        $("#modal_title_asignar").html("Registrar fecha");
        cargar_detalles(id);
    }

    function cargar_detalles(id)
    {
        var info = {};
        info["idhorario"]   = id;
        var myJsonString    = JSON.stringify(info);

        horario_detalle = $('#horario_detalle_tabla').DataTable( {
		    "ajax": {
                "type": "POST",
                "url": "<?PHP echo constant('URL'); ?>horario/GetHorarioDetalle",
                "data": {
                    "datos": myJsonString
                }
            },
			"responsive":true,
            "bSort" : false,
            "bDestroy": true,
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
			        "targets": [0],
                    "data":"dia_str"
			    },
                {
			        "targets": [1],
                    "data":"hora_inicio"
			    },
                {
			        "targets": [2],
                    "data":"hora_fin"
			    },
                {
                    "targets": [3],
                    "data":"idhorario_detalle",
                    "render": function(url, type, full){
                        var idhorario_detalle = full[0];
                        return '<button type="button" title="Eliminar detalle" onclick="eliminar_detalle('+ idhorario_detalle +');" class="btn btn-danger"><i class="fa fa-trash"></i></button> '
                        return false;
                    }
                }        
			]
			
		} );
    }

    function eliminar_detalle(id)
    {
        var info            = {};
        info["id"]          = id;
        var myJsonString    = JSON.stringify(info);
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>horario/EliminarDetalle", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                console.log(result);
                //$('#md_asignar').modal('hide');
                horario_detalle.ajax.reload();
            },
            error:function(result){
                console.log(result);
            }
        });
    }

</script>