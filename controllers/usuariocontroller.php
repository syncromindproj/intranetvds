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

        if($valido == 0 && $esadmin == 0 && $tipo != "ALU" && $tipo != "DOC"){
            $usuarios['data']['estado'] = "error_datos";
        }

        if($esadmin == 1 || $tipo == 'ALU' || $tipo == 'DOC' || $tipo == 'PDF'){
            $usuarios = $this->model->Login($datos["usuario"], $datos["clave"]);
            if($usuarios['data']['estado'] != "error_datos" && count($usuarios['data'])>0 && $usuarios['data'][0]['nombres'] != null){
                $_SESSION['nombres']        = $usuarios['data'][0]['nombres'];
                $_SESSION['usuario']        = $usuarios['data'][0]['usuario'];
                $_SESSION['idparticipante'] = $usuarios['data'][0]['idparticipante'];
                $usuarios['data']['estado'] = "OK";
                $usuarios['data']['reglamento'] = $usuarios['data'][0]['reglamento'];
                $usuarios['data']['pagos'] = $usuarios['data'][0]['pagos'];
                $usuarios['data']['idusuario'] = $usuarios['data'][0]['idusuario'];
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

    public function ActualizaAprobacionReglamento()
    {
        $datos = $_REQUEST['datos'];
        $datos  = json_decode($datos, true);
        $upd = $this->model->ActualizaAprobacionReglamento($datos['usuario']);
        echo $upd;
    }

    public function ActualizaAprobacionPagos()
    {
        $datos = $_REQUEST['datos'];
        $datos  = json_decode($datos, true);
        $upd = $this->model->ActualizaAprobacionPagos($datos['usuario']);
        echo $upd;
    }

    public function CambiarClave()
    {
        $datos = $_REQUEST['datos'];
        $datos  = json_decode($datos, true);
        $this->model->CambiarClave($datos);
        echo "La clave se cambio";
    }
} 
?>