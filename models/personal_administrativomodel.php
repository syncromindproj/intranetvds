<?PHP
class Personal_AdministrativoModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function ListaPersonalAdm()
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            * 
            FROM usuario 
            WHERE idtipo = 'DOC' or idtipo = 'ADM'");
            $query->execute();

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>