<?php
class Errores extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje = "Error al cargar el recurso2";
        $this->view->render('errores/index');
        
    }
}
?>