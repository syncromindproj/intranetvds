<?PHP require 'views/header.php'; ?>

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?PHP echo $this->title ; ?>
            </h1>
            <small><?PHP echo $this->subtitle ; ?></small>
            <ol class="breadcrumb">
                <li><a href="panel"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><a href="#">Perfil</a></li>
            </ol>
        </section>
        <section class="content">

            <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                <div class="box-body box-profile">
                    <form enctype="multipart/form-data" id="formuploadajax" method="post">
                        <img id="foto_perfil3" class="profile-user-img img-responsive img-circle" alt="User profile picture">
                        <input type="file" id="fl_imagen" name="fl_image" style="display:none;">
                        <input type="hidden" name="txt_id" value="<?php echo($_SESSION['idparticipante']); ?>" />
                        <p class="text-muted text-center"><input type="button" id="btn_upload" class="btn btn-success" value="Elegir" /></p>
                        
                    

                    <h3 class="profile-username text-center"><?php echo($_SESSION['nombres']); ?></h3>
                    <?PHP 
                        if($_SESSION['tipo'] == "ADM"){ 
                            echo '<p class="text-muted text-center">Alumno</p>';
                        } 

                        if($_SESSION['tipo'] == "DOC"){ 
                            echo '<p class="text-muted text-center">Docente</p>';
                        } 

                        if($_SESSION['tipo'] == "ALU"){ 
                            echo '<p class="text-muted text-center">Alumno</p>';
                        } 

                        if($_SESSION['tipo'] == "ADM"){ 
                            echo '<p class="text-muted text-center">Administrador</p>';
                        } 
                    ?>
                    

                    <ul class="list-group list-group-unbordered">
                    <?PHP if($_SESSION['tipo'] != "PDF"){  ?>
                    <li class="list-group-item">
                        <b>Grupo</b> <a class="pull-right" id="grupo_lbl"></a>
                    </li>
                    <?PHP } ?>
                    </ul>
                        <input type="submit" class="btn btn-primary btn-block" value="Cambiar Imagen" />
                    </form>
                </div>
                <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->
                <!--div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">About Me</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

                    <p class="text-muted">
                    B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>

                    <hr>

                    <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                    <p class="text-muted">Malibu, California</p>

                    <hr>

                    <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                    <p>
                    <span class="label label-danger">UI Design</span>
                    <span class="label label-success">Coding</span>
                    <span class="label label-info">Javascript</span>
                    <span class="label label-warning">PHP</span>
                    <span class="label label-primary">Node.js</span>
                    </p>

                    <hr>

                    <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div>
                
                </div-->
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">

            <div id="confirm_apoderado" class="alert alert-success alert-dismissible" style="display:none;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Confirmación</h4>
                <span>Los datos han sido actualizados</span>
            </div>

            <?PHP if($_SESSION['tipo'] == "ALU"){ ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#generales" data-toggle="tab">Datos Generales</a></li>
                        <!--li><a href="#estudios" data-toggle="tab">Estudios</a></li>
                        <li><a href="#salud" data-toggle="tab">Salud</a></li-->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="generales">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Nombres</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="txt_nombres" placeholder="Nombres">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Apellidos</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="txt_apellidos" placeholder="Apellidos">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Correo</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txt_correo" placeholder="Correo">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Celular</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txt_celular" placeholder="Celular">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">DNI</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled id="txt_dni" placeholder="DNI">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Dirección</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txt_direccion" placeholder="Dirección">
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" id="btn_actualizar" class="btn btn-danger">Actualizar</button>
                                </div>
                                </div>
                            </form>
                        </div>
                        <!--div class="tab-pane" id="estudios">
                        
                        </div-->
                        
                        
                        
                    </div>
                </div>
                <?PHP } ?>

                <?PHP if($_SESSION['tipo'] == "PDF"){ ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#generales" data-toggle="tab">Datos Generales</a></li>
                        <li><a href="#claves" data-toggle="tab">Cambiar Clave</a></li>
                        <!--li><a href="#salud" data-toggle="tab">Salud</a></li-->
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="generales">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Nombres</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="txt_nombres" placeholder="Nombres">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Apellidos</label>

                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="txt_apellidos" placeholder="Apellidos">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Correo</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txt_correo" placeholder="Correo">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputExperience" class="col-sm-2 control-label">Celular</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txt_celular" placeholder="Celular">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">DNI</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" disabled id="txt_dni" placeholder="DNI">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">Dirección</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txt_direccion" placeholder="Dirección">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">Telefono fijo</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="txt_telefono" placeholder="Teléfono fijo">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="inputSkills" class="col-sm-2 control-label">¿Encargado pagos?</label>
                                    <div class="col-sm-10">
                                        <input type="checkbox" id="chk_pagos">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" id="btn_actualizar" class="btn btn-danger">Actualizar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="claves">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Nueva clave</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="txt_clave" placeholder="Nueva clave">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail" class="col-sm-2 control-label">Repetir nueva clave</label>

                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="txt_repetirclave" placeholder="Repetir nueva clave">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="button" id="btn_cambiarclave" class="btn btn-danger">Cambiar Clave</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        
                        
                    </div>
                </div>
                <?PHP } ?>

                <?PHP if($_SESSION['tipo'] == "DOC"){ ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Datos Generales</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Nombres</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="txt_nombres" placeholder="Nombres">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Apellidos</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="txt_apellidos" placeholder="Apellidos">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Correo</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txt_correo" placeholder="Correo">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Celular</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="txt_celular" placeholder="Celular">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">DNI</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled id="txt_dni" placeholder="DNI">
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="button" id="btn_actualizar" class="btn btn-danger">Actualizar</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?PHP } ?>
            </div>
        </div>

        </section>
</div>

<!-- Main Footer -->
<?PHP require 'views/footer.php'; ?>
<!-- /.main-footer -->
<script>
    $(document).ready(function() {
        $("#btn_upload").click(function(){
            $("#fl_imagen").click();
        });

        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ALU'){ ?>
            var id  = '<?PHP echo($_SESSION['idparticipante']); ?>';
            ver_alumno(id);

            $("#formuploadajax").on("submit", function(e){
                e.preventDefault();
                $.ajax({
                    url: "<?PHP echo constant('URL'); ?>alumno/CambiaImagen", 
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function(result){
                        console.log(result);
                        ver_alumno(id);
                    }
                });
            });

            get_grupo();

            $("#btn_actualizar").click(function(){
                var id          = '<?PHP echo($_SESSION['idparticipante']); ?>';
                
                var nombres         = $("#txt_nombres").val();
                var apellidos       = $("#txt_apellidos").val();
                var correo          = $("#txt_correo").val();
                var celular         = $("#txt_celular").val();
                var dni             = $("#txt_dni").val();
                var direccion       = $("#txt_direccion").val();
                var info            = {};
                info["id"]          = id;
                info["nombres"]     = nombres;
                info["apellidos"]   = apellidos;
                info["correo"]      = correo;
                info["celular"]     = celular;
                info["dni"]         = dni;
                info["direccion"]   = direccion;
                var myJsonString    = JSON.stringify(info);
                
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>alumno/ActualizaAlumnoPerfil", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $("#confirm_apoderado").show().delay(2000).fadeOut();
                        ver_alumno(id);
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            });
        <?PHP } ?>

        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'PDF'){ ?>
            var id  = '<?PHP echo($_SESSION['idparticipante']); ?>';
            ver_padre(id);

            $("#formuploadajax").on("submit", function(e){
                e.preventDefault();
                $.ajax({
                    url: "<?PHP echo constant('URL'); ?>apoderado/CambiaImagen", 
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function(result){
                        console.log(result);
                        ver_padre(id);
                    }
                });
            });

            $("#btn_cambiarclave").click(function(){
                var id    = '<?PHP echo($_SESSION['idparticipante']); ?>';
                var clave = $("#txt_clave").val();
                var repetir_clave = $("#txt_repetirclave").val();

                if(clave == repetir_clave){
                    var info = {};
                    info["id"] = id;
                    info["clave"] = clave;
                    var myJsonString = JSON.stringify(info);
                    $.ajax({
                        type: "POST",
                        url: "<?PHP echo constant('URL'); ?>usuario/CambiarClave", 
                        data:{
                            datos: myJsonString
                        },
                        success:function(result){
                            console.log(result);
                            alert("La clave se cambio exitosamente");
                            cierra_sesion();
                        },
                        error:function(result){
                            console.log(result);
                        }
                    });
                }else{
                    alert("Las claves no son iguales");
                }
            });

            $("#btn_actualizar").click(function(){
                var id          = '<?PHP echo($_SESSION['idparticipante']); ?>';
                var nombres     = $("#txt_nombres").val();
                var apellidos   = $("#txt_apellidos").val();
                var correo      = $("#txt_correo").val();
                var celular     = $("#txt_celular").val();
                var dni         = $("#txt_dni").val();
                var direccion   = $("#txt_direccion").val();
                var telefono    = $("#txt_telefono").val();
                var pagos       = $("#chk_pagos").val();
                var info        = {};
                info["id"]      = id;
                info["nombres"]     = nombres;
                info["apellidos"]   = apellidos;
                info["correo"]      = correo;
                info["celular"]     = celular;
                info["dni"]         = dni;
                info["direccion"]   = direccion;
                info["fijo"]        = telefono;
                info["pagos"]       = pagos;
                var myJsonString    = JSON.stringify(info);
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>apoderado/ActualizaApoderado", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $("#confirm_apoderado").show().delay(2000).fadeOut();
                        
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            });
        <?PHP } ?>

        <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'DOC'){ ?>
            ver_docente();
            $("#formuploadajax").on("submit", function(e){
                e.preventDefault();
                $.ajax({
                    url: "<?PHP echo constant('URL'); ?>docente/CambiaImagen", 
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData:false,
                    success:function(result){
                        console.log(result);
                        ver_docente();
                    }
                });
            });
            
            $("#btn_actualizar").click(function(){
                var id          = '<?PHP echo($_SESSION['idparticipante']); ?>';
                console.log(id);
                var nombres     = $("#txt_nombres").val();
                var apellidos   = $("#txt_apellidos").val();
                var correo      = $("#txt_correo").val();
                var celular     = $("#txt_celular").val();
                var dni         = $("#txt_dni").val();
                var info        = {};
                info["id"]      = id;
                info["nombres"]     = nombres;
                info["apellidos"]   = apellidos;
                info["correo"]      = correo;
                info["celular"]     = celular;
                info["dni"]         = dni;
                var myJsonString    = JSON.stringify(info);
                $.ajax({
                    type: "POST",
                    url: "<?PHP echo constant('URL'); ?>docente/ActualizaDocente", 
                    data:{
                        datos: myJsonString
                    },
                    success: function(result){
                        console.log(result);
                        $("#confirm_apoderado").show().delay(2000).fadeOut();
                    },
                    error:function(result){
                        console.log(result);
                    }
                });
            });
        <?PHP } ?>
        //
        

        
    });

    function ver_padre(id){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>apoderado/GetApoderado", 
            data:{
                datos: '{"id": "' + id + '"}'
            },
            success: function(result){
                var datos = jQuery.parseJSON(result);
                console.log(datos);
                $("#txt_nombres").val(datos.nombres);
                $("#txt_apellidos").val(datos.apellidos);
                $("#txt_nacimiento").val(datos.fecha_nacimiento);
                $("#txt_dni").val(datos.dni);
                $("#txt_direccion").val(datos.direccion);
                $("#txt_celular").val(datos.celular);
                $("#txt_correo").val(datos.correo);
                $("#txt_telefono").val(datos.telefono_fijo);
                if(datos.encargado_pagos == "1"){
                    $("#chk_pagos").attr("checked", true);
                }
                
                $("#foto_perfil1").attr("src", datos.imagen);
                $("#foto_perfil2").attr("src", datos.imagen);
                $("#foto_perfil3").attr("src", datos.imagen);
                $("#foto_perfil4").attr("src", datos.imagen);
            },
            error:function(result){
                console.log(result);
            }
        });

    }

    function ver_alumno(id){
        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>alumno/VerAlumno", 
            data:{
                datos: '{"idalumno": "' + id + '"}'
            },
            success: function(result){
                var datos = jQuery.parseJSON(result);
                $("#txt_nombres").val(datos.nombres);
                $("#txt_apellidos").val(datos.apellidos);
                $("#txt_nacimiento").val(datos.fecha_nacimiento);
                $("#txt_dni").val(datos.dni);
                $("#txt_direccion").val(datos.direccion);
                $("#txt_celular").val(datos.celular_postulante);
                $("#txt_correo").val(datos.correo_postulante);
                $("#foto_perfil1").attr("src", datos.imagen);
                $("#foto_perfil2").attr("src", datos.imagen);
                $("#foto_perfil3").attr("src", datos.imagen);
                $("#foto_perfil4").attr("src", datos.imagen);
            },
            error:function(result){
                console.log(result);
            }
        });
    
    }

    function ver_docente(){
        var info        = {};
        info["id"]    = '<?PHP echo($_SESSION['idparticipante']); ?>';
        var myJsonString  = JSON.stringify(info);
        console.log(myJsonString);

        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>docente/VerDocente", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                var docente = JSON.parse(result);
                $("#txt_nombres").val(docente[0].nombres);
                $("#txt_apellidos").val(docente[0].apellidos);
                $("#txt_correo").val(docente[0].correo);
                $("#txt_celular").val(docente[0].celular);
                $("#txt_dni").val(docente[0].dni);
                $("#foto_perfil1").attr("src", docente[0].imagen);
                $("#foto_perfil2").attr("src", docente[0].imagen);
                $("#foto_perfil3").attr("src", docente[0].imagen);
                $("#foto_perfil4").attr("src", docente[0].imagen);
                console.log(docente);
            },
            error:function(result){
                console.log(result);
            },
            complete: function() {
                //setInterval(GetInfoPanel(tipo, div), 5000); 
            }
        });
    }

    function get_grupo(){
        var info        = {};
        info["id"]    = '<?PHP echo($_SESSION['idparticipante']); ?>';
        var myJsonString  = JSON.stringify(info);
        console.log(myJsonString);

        $.ajax({
            type: "POST",
            url: "<?PHP echo constant('URL'); ?>grupo/GetGrupoParticipante", 
            data:{
                datos: myJsonString
            },
            success: function(result){
                var datos = JSON.parse(result);
                $("#grupo_lbl").html(datos.data[0].descripcion);
                console.log(datos);
            },
            error:function(result){
                console.log(result);
            },
            complete: function() {
                //setInterval(GetInfoPanel(tipo, div), 5000); 
            }
        });
    }
</script>