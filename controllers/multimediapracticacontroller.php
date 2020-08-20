<?PHP
class MultimediaPracticaController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->title = "Multimedia";
        $this->view->subtitle = "Listado de Archivos";
        $this->view->render('multimediapractica/index');
    }

    public function ListaMultimedia()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->ListaMultimedia($datos);
        echo json_encode($multimedia);
    }

    public function GuardarComentario()
    {
        $path   = 'views/uploads/audios';
        $rand = time();
        $newfilename = $rand.'.wav';
        $idmultimedia = $_REQUEST['idmultimedia'];
        $size = $_FILES['audio_data']['size']; //the size in bytes
        $input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file
        $output = $_FILES['audio_data']['name']; //letting the client control the filename is a rather bad idea

        if(move_uploaded_file($input, ($path .'/' . $newfilename))){
            $multimedia = $this->model->GuardarComentario($newfilename, $idmultimedia);
            echo(json_encode($multimedia));
        }
    }

    public function EliminaComentario(){
        $datos = $_REQUEST['data'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->EliminaComentario($datos['id']);
        echo json_encode($multimedia);
    }

    public function Aprobar(){
        $datos = $_REQUEST['data'];
        $datos = json_decode($datos, true);
        $multimedia = $this->model->Aprobar($datos['id'], $datos['estado']);
        echo json_encode($multimedia);
    }

    public function EnviarNotificaciones()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $respuesta = $this->model->EnviarNotificaciones($datos);
        echo json_encode($respuesta);
    }

    public function EnviarNotificacionesAprobacion()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $respuesta = $this->model->EnviarNotificacionesAprobacion($datos);
        echo json_encode($respuesta);
    }
}
?>