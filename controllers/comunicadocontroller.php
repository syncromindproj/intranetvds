<?PHP
class ComunicadoController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Comunicados";
        $this->view->subtitle = "Listado de Comunicados";
        $this->view->render('comunicado/index');
    }

    public function getComunicados()
    {
        $comunicados = $this->model->getComunicados();
        echo(json_encode($comunicados));
    }

    public function Subir()
    {
        $img            = $_FILES["files"]["name"][0];
        $tmp            = $_FILES["files"]["tmp_name"][0];
        $errorimg       = $_FILES["files"]["error"][0];
        $descripcion    = $_REQUEST['descripcion'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        
        $path   = 'views/uploads/comunicados';
        $rand = rand(10000, 99999);
        //$path .= "/" . $rand . "_" . strtolower($img);
        $path .= "/" . $rand . "_file.".$ext;
        
        if(move_uploaded_file($tmp,$path)) 
        {
            $comunicado = $this->model->InsertaComunicado($path, $descripcion);
            echo(json_encode($comunicado));
        }
        
    }

    public function EliminaComunicado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $comunicado = $this->model->EliminaComunicado($datos["idcomunicado"]);
        echo json_encode($comunicado);
        
    }

    public function AsignarComunicado()
    {
        $datos = $_REQUEST['datos'];
        $comunicado = $this->model->AsignarComunicado($datos);
        echo json_encode($comunicado);
    }

    public function GetComunicadoByParticipante()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $comunicados = $this->model->GetComunicadoByParticipante($datos);
        echo json_encode($comunicados);
    }

    public function EnviarComunicado()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $comunicados = $this->model->EnviarComunicado($datos);
        echo $comunicados;
    }
}
?>