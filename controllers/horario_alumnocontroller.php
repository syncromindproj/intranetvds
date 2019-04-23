<?PHP
class Horario_AlumnoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        //$grupos = $this->model->get();
        //$this->view->grupos = $grupos;
        $this->view->title = "Horario";
        $this->view->subtitle = "Horario de clase";
        $this->view->render('horario_alumno/index');
    }
}
?>