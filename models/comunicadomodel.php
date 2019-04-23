<?PHP
class ComunicadoModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getComunicados()
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            select c.idcomunicado, g.descripcion as grupo, c.url, c.descripcion from comunicado c
            inner join grupo g
            on g.idgrupo = c.idgrupo where c.estado=1");
            /*$query->execute([
                'idhorario'       => $datos['idhorario']
            ]);*/
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

    function InsertaComunicado($idgrupo, $url, $descripcion)
    {
        try{
            
            $query = $this->db->connect()->prepare('insert into comunicado (idgrupo, url, descripcion)
            values (:idgrupo, :url, :descripcion)');
            $query->execute([
                'idgrupo'       => $idgrupo,
                'url'           => $url,
                'descripcion'   => $descripcion
            ]);
            return "Comunicado Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaComunicado($idcomunicado)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('select url from comunicado where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado'   => $idcomunicado
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['url'];
            }

            $query = $this->db->connect()->prepare('delete from comunicado where idcomunicado = :idcomunicado');
            $query->execute([
                'idcomunicado'   => $idcomunicado
            ]);

            if (file_exists($archivo)) {
                unlink($archivo);
            }

            return $archivo;    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }
}
?>