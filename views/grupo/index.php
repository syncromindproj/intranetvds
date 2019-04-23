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
        <li><a href="#">Reportes</a></li>
        <li class="active">Reporte de Audiciones 2019</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
       
    <div id="confirm_grupo" class="alert alert-success alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Confirmación</h4>
        <span id="mensaje_confirmacion"></span>
    </div>

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
                    <table id="grupos" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Profesor Asignado</th>
                                <th>Cantidad Alumnos</th>
                                <th>Opciones</th>
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
                    <form id="frm_grupo" method="POST">
                        <div class="form-row">
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

        <!-- Div Asignar -->
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
                                <label for="sl_docente">Docentes</label>
                                <select required class="form-control" id="sl_docente" name="sl_docente"></select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btn_asignar" data-value="" name="btn_asignar" class="btn btn-primary">Asignar</button>
                </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Div Asignar -->


        <!-- Delete Modal -->
        <div class="modal modal-danger fade" id="modal-delete">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">¿Eliminar Registro?</h4>
              </div>
              <div class="modal-body">
                <p>Desea eliminar el grupo: <span id="sp_grupo"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btn_elimina" class="btn btn-outline">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- End Delete Modal -->

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

<script>
    var grupos = "";

    $(document).ready(function() {
        var idgrupo = "";
        var opcion = "";

		grupos = $('#grupos').DataTable( {
		    "ajax": "<?PHP echo constant('URL'); ?>grupo/GetGruposAsignados",
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
                    "data": "descripcion"
                },
                {
			        "targets": [1],
                    "data":"nombres"
			    },
                {
                    "targets": [2],
                    "data":"cantidad"
                },
                {
                    "targets": [3],
                    "data":"idgrupo",
                    "render": function(url, type, full){
                        var idgrupo = full[0];
                        return '<button type="button" onclick="asignar_grupo('+ full[0] +');" class="btn btn-warning"><i class="fa fa-plus-square"></i> Asignar Docente</button> <button class="edit btn btn-primary"><i class="fa fa-pencil"></i> Editar</button> <button class="delete btn btn-danger"><i class="fa fa-remove"></i> Eliminar</button>'
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
                        $("#modal_title").html("Nuevo Grupo");
                        $("#btn_enviar").text("Guardar");
                        $("#txt_descripcion").val("");
                        $("#txt_descripcion").focus();
					}
                }
			]
		} );
		
		$("#frm_grupo").submit(function(event){
            event.preventDefault();
            var descripcion = $("#txt_descripcion").val();
            if(opcion == "nuevo"){
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>grupo/GuardarGrupo", 
                    data:{
                        datos: '{"descripcion": "' + descripcion + '"}'
                    },
                    success: function(result){
                        console.log(result);
                        $('#md_nuevo').modal('hide');
                        grupos.ajax.reload();	
                        $("#mensaje_confirmacion").html("Se ha registrado el nuevo grupo.");
                        $("#confirm_grupo").show().delay(2000).fadeOut();
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }

            if(opcion == "editar"){
                var descripcion = $("#txt_descripcion").val();

                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>grupo/ActualizaGrupo", 
                    data:{
                        datos: '{"descripcion": "' + descripcion + '", "idgrupo": "' + idgrupo + '"}'
                    },
                    success: function(result){
                        console.log(result);
                        $('#md_nuevo').modal('hide');
                        grupos.ajax.reload();	
                        $("#mensaje_confirmacion").html("Se ha actualizado la información del grupo.");
                        $("#confirm_grupo").show().delay(2000).fadeOut();
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }
            
        });

        $('#grupos tbody').on( 'click', 'button', function () {
            var data = grupos.row( $(this).parents('tr') ).data();
            idgrupo = data['idgrupo'];
            var descripcion = data['descripcion'];
            
            var option = $(this)[0].classList[0];
            if(option == "edit"){
                opcion = "editar";
                $('#md_nuevo').modal();
                $("#modal_title").html("Actualizar Grupo");
                $("#btn_enviar").text("Actualizar");
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>grupo/VerGrupo", 
                    data:{
                        datos: '{"idgrupo": "' + idgrupo + '"}'
                    },
                    success: function(result){
                        var datos = jQuery.parseJSON(result);
                        $("#txt_descripcion").val(datos.descripcion);
                        console.log(idgrupo);
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            }

            if(option == "delete"){
                $('#modal-delete').modal();
                $('#sp_grupo').html(descripcion);
                console.log("delete" + idgrupo);
            }
        });
       
        $("#btn_elimina").click(function(){
            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>grupo/EliminaGrupo", 
                data:{
                    datos: '{"idgrupo": "' + idgrupo + '"}'
                },
                success: function(result){
                    console.log(result);
                    $('#modal-delete').modal('hide');
                    grupos.ajax.reload();	
                    $("#mensaje_confirmacion").html(result);
                    $("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });

        $("#frm_asignar").submit(function(event){
            event.preventDefault();
            var iddocente   = $("#sl_docente").val();
            var idgrupo     = $("#btn_asignar").attr("data-value");
            var info = {};
            info["iddocente"]   = iddocente;
            info["idgrupo"]     = idgrupo;
            var myJsonString = JSON.stringify(info);

            $.ajax({
                type: "POST",
                url: "<?PHP echo constant('URL'); ?>grupo/AsignarDocente", 
                data:{
                    datos: myJsonString
                },
                success: function(result){
                    console.log(result);
                    $("#md_asignar").modal('hide');
                    grupos.ajax.reload();
                    $("#mensaje_confirmacion").html("Se ha asignado un docente al grupo.");
                    $("#confirm_grupo").show().delay(2000).fadeOut();
                },
                error:function(result){
                    console.log(result);
                }
            });
        });

        //Cargar lista de docentes en combo
        cargaDocentes();

    } );
    
    function asignar_grupo(id)
    {
        $("#md_asignar").modal();
        $("#modal_title_asignar").html("Asignar Docente");
        $("#btn_asignar").attr("data-value", id);
    }

    function cargaDocentes()
    {
        $("#sl_docente").empty();
        $("#sl_docente").append('<option value="" selected="selected">Seleccione un docente</option>');
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "<?PHP echo constant('URL'); ?>docente/GetDocentes", 
            success: function(result){
                $.each(result.data, function(i,v){
                    var iddocente   = v.iddocente;
                    var apellidos   = v.apellidos;
                    var nombres     = v.nombres;
                    $("#sl_docente").append('<option value="' + iddocente +'">'+ apellidos +', '+ nombres +'</option>');
                });
            }
        });
    }
    
</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
     </body>
</html>