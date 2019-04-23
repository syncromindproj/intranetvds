<?PHP
class PanelController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function render(){
        //$placas = $this->model->get();
        //$this->view->placas = $placas;
        $this->view->title = "Panel de administración";
        $this->view->subtitle = "Panel";
        $this->view->render('panel/index');
    }
}
?>