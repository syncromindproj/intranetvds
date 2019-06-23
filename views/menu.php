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
        <li><a href="comunicado"><i class="fa fa-link"></i> <span>Comunicados</span></a></li>
        <li><a href="evento"><i class="fa fa-link"></i> <span>Eventos</span></a></li>
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
        <li><a href="horario_alumno"><i class="fa fa-link"></i> <span>Horario de Clase</span></a></li>
        <li><a href="personal_administrativo"><i class="fa fa-link"></i> <span>Personal Administrativo</span></a></li>
    <?PHP } ?>

    <?PHP if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 'DOC'){ ?>
        <li><a href="perfil"><i class="fa fa-link"></i> <span>Mi Perfil</span></a></li>
        <li><a href="alumno"><i class="fa fa-link"></i> <span>Alumnos</span></a></li>
        <li><a href="material"><i class="fa fa-link"></i> <span>Material Académico</span></a></li>
        <li><a href="reporte_academico"><i class="fa fa-link"></i> <span>Reporte Académico</span></a></li>
    <?PHP } ?>
</ul>