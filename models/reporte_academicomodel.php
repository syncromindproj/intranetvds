<?PHP
class Reporte_AcademicoModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function InsertaInforme($url, $titulo, $idparticipante)
    {
        try{
            
            $query = $this->db->connect()->prepare('call inserta_informe (:url, :titulo, :idparticipante)');
            $query->execute([
                'url'               => $url,
                'titulo'            => $titulo,
                'idparticipante'    => $idparticipante
            ]);
            return "Material Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaInforme($id)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('select url from informe where idinforme = :id');
            $query->execute([
                'id'   => $id
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['url'];
            }

            $query = $this->db->connect()->prepare('delete from informe where idinforme = :id');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from informe_participante where idinforme = :id');
            $query->execute([
                'id'   => $id
            ]);

            if (file_exists($archivo)) {
                unlink($archivo);
            }

            return $archivo;    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }

    public function GetReporteByParticipante($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            i.* 
            FROM informe_participante ip
            inner join informe i
            on i.idinforme = ip.idinforme
            where ip.idparticipante = :idparticipante');
            $query->execute([
                'idparticipante' => $datos['idalumno']
            ]);
            
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