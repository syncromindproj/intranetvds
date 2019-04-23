<?PHP
class DocenteController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Docentes";
        $this->view->subtitle = "Listado de Docentes";
        $this->view->render('docente/index');
    }

    public function GetDocentes()
    {
        $docentes = $this->model->GetDocentes();
        echo(json_encode($docentes));
    }

    public function VerDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $docente = $this->model->VerDocente($datos['id']);
        echo(json_encode($docente));
    }

    public function RegistraDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $mensaje = $this->model->RegistraDocente($datos);
        echo $mensaje;
    }

    public function CambiaImagen()
    {
        $img = $_FILES["fl_image"]["name"];
        $tmp = $_FILES["fl_image"]["tmp_name"];
        $id  = $_REQUEST["txt_id"];
        $mensaje = "";
        
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        
        $path   = 'views/dist/img';
        $rand = rand(10000, 99999);
        $path .= "/" . $rand . "_file.".$ext;
        if(move_uploaded_file($tmp,$path)) 
        {
            $mensaje = $this->model->ActualizaImageDocente($id, $path);
        }
        
        echo $mensaje;
    }

    public function ActualizaDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $mensaje = $this->model->ActualizaDocente($datos);
        echo $mensaje;
    }

    public function EliminaDocente()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $this->model->EliminaDocente($datos['id']);
        echo "Registro Eliminado";
    }
}
?>