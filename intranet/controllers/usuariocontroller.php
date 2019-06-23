<?php
class UsuarioController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    public function Login()
    {
        session_start();
        $datos = $_REQUEST['datos'];
        $datos  = json_decode($datos, true);
            
        $valido     = 0;
        $esadmin    = 0;
        $usuarios   = [];
        $tipo       = "";

        $tipo = $this->model->ObtieneTipo($datos["usuario"]);
        if($tipo == "ADM"){
            $esadmin = 1;
        }

        
        if($valido == 1 && $esadmin == 0){
            $usuarios = $this->model->Login($datos["usuario"], $datos["clave"]);
            if($usuarios['data'] != "error_datos" && count($usuarios['data'])>0 && $usuarios['data'][0]['nombres'] != null){
                $_SESSION['nombres'] = $usuarios['data'][0]['nombres'];
                $_SESSION['usuario'] = $usuarios['data'][0]['usuario'];
            }
        }

        if($valido == 0 && $esadmin == 0 && $tipo != "CLI"){
            $usuarios['data']['estado'] = "error_datos";
        }

        if($esadmin == 1 || $tipo == 'CLI'){
            $usuarios = $this->model->Login($datos["usuario"], $datos["clave"]);
            if($usuarios['data']['estado'] != "error_datos" && count($usuarios['data'])>0 && $usuarios['data'][0]['nombres'] != null){
                $_SESSION['nombres'] = $usuarios['data'][0]['nombres'];
                $_SESSION['usuario'] = $usuarios['data'][0]['usuario'];
                $usuarios['data']['estado'] = "OK";
            }
        }
        $_SESSION['tipo'] = $tipo;
        $usuarios['data']['tipo'] = $tipo;
        echo json_encode($usuarios);        
    }

    public function CerrarSesion()
    {
        session_start();
        session_destroy();
    }
} 
?>