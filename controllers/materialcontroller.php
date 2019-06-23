<?PHP
class MaterialController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Materiales";
        $this->view->subtitle = "Listado de Materiales";
        $this->view->render('material/index');
    }

    public function ListaMateriales()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $materiales = $this->model->ListaMateriales($datos);
        echo json_encode($materiales);
    }

    public function Subir()
    {
        $img            = $_FILES["files"]["name"][0];
        $tmp            = $_FILES["files"]["tmp_name"][0];
        $errorimg       = $_FILES["files"]["error"][0];
        $titulo         = $_REQUEST['titulo'];
        $descripcion    = $_REQUEST['descripcion'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        
        $path   = 'views/uploads/materiales';
        $rand = rand(10000, 99999);
        //$path .= "/" . $rand . "_" . strtolower($img);
        $path .= "/" . $rand . "_file.".$ext;
        
        if(move_uploaded_file($tmp,$path)) 
        {
            $material = $this->model->InsertaMaterial($path, $titulo, $descripcion);
            echo(json_encode($material));
        }
        
    }

    public function EliminaMaterial()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $material = $this->model->EliminaMaterial($datos["id"]);
        echo json_encode($material);
        
    }

    public function AsignarGrupo()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $material = $this->model->AsignarGrupo($datos);
        echo json_encode($material);
        
    }

    public function GetMaterialByParticipante()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $materiales = $this->model->GetMaterialByParticipante($datos);
        echo json_encode($materiales);
    }
}
?>