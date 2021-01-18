<ul class="sidebar-menu" data-widget="tree">
    <li class="header">NAVEGACIÓN</li>
    <!-- Optionally, you can add icons to the links -->
    <?PHP
        if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ADM'){
    ?>
        <li><a href="grupo"><i class="fa fa-link"></i> <span>Grupos</span></a></li>
        <li><a href="horario"><i class="fa fa-link"></i> <span>Horarios</span></a></li>
        <li><a href="alumno"><i class="fa fa-link"></i> <span>Alumnos</span></a></li>
        <li><a href="docente"><i class="fa fa-link"></i> <span>Docentes</span></a></li>
        <li><a href="multimediaadmin"><i class="fa fa-play-circle"></i> <span>Multimedia</span></a></li>
        <li><a href="comunicado"><i class="fa fa-link"></i> <span>Comunicados</span></a></li>
        <li><a href="evento"><i class="fa fa-link"></i> <span>Eventos</span></a></li>
        <li><a href="horario_coros"><i class="fa fa-link"></i> <span>Calendario de Actividades</span></a></li>
        <li><a href="preinscripcion"><i class="fa fa-link"></i> <span>Preinscripción</span></a></li>
        <!--li class="treeview" >
            <a href="#">
            <i class="fa fa-table"></i> <span>Participantes</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
            <li class="active"><a href="participante"> Reporte de Audiciones 2019</a></li>
            <li><a href="descarga.php"><i class="fa fa-circle-o"></i> Descarga de Correos</a></li>
            <li><a href="evaluacion.php"><i class="fa fa-circle-o"></i> Evaluación de Audiciones 2019</a></li>
            </ul>
        </li-->
    <?PHP } ?>
    
    <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'ALU'){ ?>
        <li><a href="perfil"><i class="fa fa-link"></i> <span>Mi Perfil</span></a></li>
        <li><a href="multimediaalumno"><i class="fa fa-link"></i> <span>Multimedia</span></a></li>
        <li><a href="horario_alumno"><i class="fa fa-link"></i> <span>Calendario de Actividades</span></a></li>
        <li><a href="personal_administrativo"><i class="fa fa-link"></i> <span>Personal Administrativo y Docente</span></a></li>
    <?PHP } ?>

    <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'PDF'){ ?>
        <li><a href="perfil"><i class="fa fa-link"></i> <span>Mi Perfil</span></a></li>
        <li><a href="horario_alumno"><i class="fa fa-link"></i> <span>Calendario de Actividades</span></a></li>
        <li><a href="datos_hijos"><i class="fa fa-link"></i> <span>Datos de Hijos</span></a></li>
        <li><a href="personal_administrativo"><i class="fa fa-link"></i> <span>Personal Administrativo y Docente</span></a></li>
    <?PHP } ?>

    <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'DOC'){ ?>
        <li><a href="perfil"><i class="fa fa-link"></i> <span>Mi Perfil</span></a></li>
        <li><a href="alumno"><i class="fa fa-link"></i> <span>Alumnos</span></a></li>
        <li><a href="material"><i class="fa fa-link"></i> <span>Material Académico</span></a></li>
        
        <!--li><a href="multimedia"><i class="fa fa-link"></i> <span>Multimedia</span></a></li-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-play-circle"></i> <span>Multimedia</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="multimedia"><i class="fa fa-circle-o"></i> Docente</a></li>
            <li><a href="multimediapractica"><i class="fa fa-circle-o"></i> Alumnos</a></li>
          </ul>
        </li>

        <li><a href="reporte_academico"><i class="fa fa-link"></i> <span>Reporte Académico</span></a></li>
        <li><a href="horario_coros"><i class="fa fa-link"></i> <span>Calendario de Actividades</span></a></li>
    <?PHP } ?>
</ul>