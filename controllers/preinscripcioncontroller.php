<?php
class PreinscripcionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Preinscripción";
        $this->view->subtitle = "Listado de Registros";
        $this->view->render('preinscripcion/index');
    }

    public function ListaPersonas()
    {
        $multimedia = $this->model->ListaPersonas();
        echo json_encode($multimedia);
    }

    public function GetPersonaById()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->GetPersonaById($datos);
        echo json_encode($multimedia);
    }

    public function RechazarPostulante()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->RechazarPostulante($datos);
        echo json_encode($info);
    }

    public function AprobarPostulante()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $info = $this->model->AprobarPostulante($datos);
        echo json_encode($info);
    }
    
}
?>