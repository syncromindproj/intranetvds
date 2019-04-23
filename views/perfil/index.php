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
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
                    <li class="list-group-item">
                        <b>Grupo</b> <a class="pull-right">Grupo del Sol</a>
                    </li>
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
                <?PHP if($_SESSION['tipo'] == "PDF"){ ?>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#settings" data-toggle="tab">Datos Generales</a></li>
                        <li><a href="#settings" data-toggle="tab">Estudios</a></li>
                        <li><a href="#salud" data-toggle="tab">Salud</a></li>
                        <li><a href="#apoderados" data-toggle="tab">Apoderados</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="timeline">
                        
                        </div>
                        
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputName" placeholder="Name">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" placeholder="Name">
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                </div>
                                </div>
                                <div class="form-group">
                                <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                    </label>
                                    </div>
                                </div>
                                </div>
                                <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Submit</button>
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
                                    <input type="text" class="form-control" id="txt_dni" placeholder="DNI">
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

        ver_docente();

        $("#btn_actualizar").click(function(){
            var id          = '<?PHP echo($_SESSION['idparticipante']); ?>';
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
                    
                },
                error:function(result){
                    console.log(result);
                }
            });
        });
    });

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
</script>