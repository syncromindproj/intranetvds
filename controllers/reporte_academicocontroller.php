<?PHP
class Reporte_AcademicoController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Reporte Académico";
        $this->view->subtitle = "Reporte Académico";
        $this->view->render('reporte_academico/index');
    }

    public function Subir()
    {
        $img                = $_FILES["files"]["name"][0];
        $tmp                = $_FILES["files"]["tmp_name"][0];
        $errorimg           = $_FILES["files"]["error"][0];
        $titulo             = $_REQUEST['titulo'];
        $idparticipante     = $_REQUEST['idparticipante'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        
        $path   = 'views/uploads/informes';
        $rand = rand(10000, 99999);
        //$path .= "/" . $rand . "_" . strtolower($img);
        $path .= "/" . $rand . "_file.".$ext;
        
        if(move_uploaded_file($tmp,$path)) 
        {
            $informe = $this->model->InsertaInforme($path, $titulo, $idparticipante);
            echo(json_encode($informe));
        }
        
    }

    public function EliminaInforme()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $material = $this->model->EliminaInforme($datos["idinforme"]);
        echo json_encode($material);
        
    }

    public function GetReporteByParticipante()
    {
        $datos = $_REQUEST['datos'];
        $datos = json_decode($datos, true);
        $reportes = $this->model->GetReporteByParticipante($datos);
        echo json_encode($reportes);
    }
}
?>