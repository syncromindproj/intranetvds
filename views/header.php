<?php
  session_start();
  if(!isset($_SESSION['nombres']) && $this->title != "Registro"){
    header("Location:/intranet");
  }
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?PHP echo constant('TITLE'); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/dist/css/skins/skin-blue.min.css">
  <link  rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/dist/css/custom.css" />
  <link  rel="stylesheet" href="<?PHP echo constant('URL'); ?>views/public/css/general.css" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link href="https://fonts.googleapis.com/css?family=Anton" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">


</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<input type="hidden" id="txt_idparticipante" value="<?PHP echo($_SESSION['idparticipante']); ?>" />
<input type="text" style="display:none;" id="txt_grupoparticipante" />
<div class="wrapper">
    
  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="<?PHP echo constant('URL'); ?>panel" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?PHP echo(constant('TITLE')); ?></b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          
          <!-- /.messages-menu -->

          
          
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <?PHP if($this->title != "Registro"){ ?>
              <img id="foto_perfil1" src="<?PHP echo constant('URL'); ?>views/dist/img/avatar2.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo($_SESSION['nombres']); ?> </span>
              <?PHP } ?>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img id="foto_perfil2" src="<?PHP echo constant('URL'); ?>views/dist/img/avatar2.png" class="img-circle" alt="User Image">

                <p>
                  <?php echo($_SESSION['nombres']); ?> 
                  <small>Voces del Sol</small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" onclick="cierra_sesion();" class="btn btn-default btn-flat">Cerrar sesión</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <?PHP if($this->title != "Registro"){ ?>
      <div class="user-panel">
        <div class="pull-left image">
          <img id="foto_perfil4" src="<?PHP echo constant('URL'); ?>views/dist/img/avatar2.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo($_SESSION['nombres']); ?></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <?PHP } ?>
      
      <!-- Sidebar Menu -->
      <?PHP require 'views/menu.php'; ?>
      <!-- /.sidebar-menu -->
      <script>
        var info        = {};
        info["id"]    = '<?PHP echo($_SESSION['idparticipante']); ?>';
        var myJsonString  = JSON.stringify(info);

        
        function cierra_sesion(){
          $.ajax({
              type: "POST",
              url: "<?PHP echo constant('URL'); ?>usuario/CerrarSesion", 
              success: function(result){
                  console.log(result);
                  window.location = "<?PHP echo constant('URL'); ?>";
              },
              error:function(result){
                  console.log(result);
              }
          });
        }

        function carga_imagenes_docente(){
          $.ajax({
              type: "POST",
              url: "<?PHP echo constant('URL'); ?>docente/VerDocente", 
              data:{
                  datos: myJsonString
              },
              success: function(result){
                  var docente = JSON.parse(result);
                  console.log(result);
                  $("#foto_perfil1").attr("src", docente[0].imagen);
                  $("#foto_perfil2").attr("src", docente[0].imagen);
                  $("#foto_perfil3").attr("src", docente[0].imagen);
                  $("#foto_perfil4").attr("src", docente[0].imagen);
              },
              error:function(result){
                  console.log(result);
              }
          });
        }

        function carga_imagenes_apoderado(){
          $.ajax({
              type: "POST",
              url: "<?PHP echo constant('URL'); ?>apoderado/GetApoderado", 
              data:{
                  datos: myJsonString
              },
              success: function(result){
                  var datos = jQuery.parseJSON(result);
                  console.log(result);
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

        function carga_imagenes_alumno(){
          var info        = {};
          info["idalumno"]    = '<?PHP echo($_SESSION['idparticipante']); ?>';
          var myJsonString  = JSON.stringify(info);
          $.ajax({
              type: "POST",
              url: "<?PHP echo constant('URL'); ?>alumno/VerAlumno", 
              data:{
                  datos: myJsonString
              },
              success: function(result){
                  var datos = jQuery.parseJSON(result);
                  console.log(result);
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
      </script>
    </section>
    <!-- /.sidebar -->
  </aside>
  