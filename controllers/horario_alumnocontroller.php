<?PHP
class Horario_AlumnoController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    function render()
    {
        $this->view->title = "Calendario";
        $this->view->subtitle = "Calendario de Actividades";
        $this->view->render('horario_alumno/index');
    }
}
?>