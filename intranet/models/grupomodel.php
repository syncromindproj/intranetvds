<?PHP
include_once 'models/grupo.php';

class GrupoModel extends Model{
    public function __construct(){
        parent::__construct();
    }

    public function get(){
        $items = [];

        try{
            $query = $this->db->connect()->query("select * from grupo order by descripcion asc");

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function GetGruposAsignados(){
        $items = [];

        try{
            $query = $this->db->connect()->query("SELECT
            g.idgrupo,
            g.descripcion,
            COALESCE(concat(d.apellidos, ', ', d.nombres),'NO ASIGNADO', concat(d.apellidos, ', ', d.nombres)) as nombres,
            count(gp.idgrupo) as cantidad,
            g.estado
            from grupo g
            left join grupo_docente gd
            on gd.idgrupo = g.idgrupo
            left join docente d
            on d.iddocente = gd.iddocente
            left join grupo_participante gp
            on gp.idgrupo = g.idgrupo
            group by g.idgrupo
            order by g.descripcion asc");

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function InsertaGrupo($datos){
        $query = $this->db->connect()->prepare('insert into grupo (descripcion) values (:descripcion)');
        $query->execute(['descripcion' => $datos['descripcion']]);
    }

    public function EliminaGrupo($id){
        $query = $this->db->connect()->prepare('delete from grupo where idgrupo=:id');
        $query->execute([
            'id' => $id
        ]);
    }

    public function ActualizaGrupo($datos){
        $query = $this->db->connect()->prepare('update grupo set descripcion = :descripcion where idgrupo=:idgrupo');
        $query->execute([
            'descripcion'   => $datos['descripcion'],
            'idgrupo'       => $datos['idgrupo']
        ]);
    }

    public function getById($id){
        $item = new Grupo();

        $query = $this->db->connect()->prepare("select * from grupo where idgrupo = :idgrupo");
        try{
            $query->execute([
                'idgrupo' => $id
            ]);
            while($row =  $query->fetch()){
                $item->idgrupo = $row['idgrupo'];
                $item->descripcion = $row['descripcion'];
                $item->estado = $row['estado'];
            }
            
            return $item;
        }catch(PDOException $e){
            return null;
        }
    }

    public function AsignarDocente($idgrupo, $iddocente)
    {
        try{
            $query = $this->db->connect()->prepare('delete from grupo_docente where idgrupo = :idgrupo');
            $query->execute(
                [
                    'idgrupo' => $idgrupo
                ]);      

            $query = $this->db->connect()->prepare('insert into grupo_docente (idgrupo, iddocente) values (:idgrupo, :iddocente)');
            $query->execute(
                [
                    'idgrupo' => $idgrupo,
                    'iddocente' => $iddocente
                ]);      
        }catch(PDOException $e){
            return null;
        }
        
    }
}
?>