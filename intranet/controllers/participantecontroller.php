<?PHP
class ParticipanteController extends Controller{
    function __construct(){
        parent::__construct(); 
        $this->view->participantes = [];
    }

    function render(){
        $participantes = $this->model->get();
        $this->view->participantes = $participantes;
        $this->view->render('participante/index');
    }

    public function getParticipantes()
    {
        $participantes = $this->model->get();
        echo(json_encode($participantes));
    }

    public function Aprobar(){
        $data = $_REQUEST['data'];
		$resultado = $this->model->Aprobar($data);
		echo(json_encode($resultado));
    }
}

?>