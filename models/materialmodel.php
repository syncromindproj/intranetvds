<?PHP
class MaterialModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function ListaMateriales($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            m.idmaterial,
            m.titulo,
            m.url,
            COALESCE(g.descripcion, 'SINGRUPO') as grupo
            FROM 
            material m
            left join material_grupo mg
            on mg.idmaterial = m.idmaterial
            left join grupo g
            on g.idgrupo = mg.idgrupo");
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

    function InsertaMaterial($url, $titulo, $descripcion)
    {
        try{
            
            $query = $this->db->connect()->prepare('insert into material (titulo, url, descripcion)
            values (:titulo, :url, :descripcion)');
            $query->execute([
                'titulo'        => $titulo,
                'url'           => $url,
                'descripcion'   => $descripcion
            ]);
            return "Material Insertado";
        }catch(PDOException $e){
            return $e->getCode();
            //die(parent::outputPDOerror($e->getCode()));
        }
    }

    function EliminaMaterial($id)
    {
        $archivo = "";
        
        try{
            $query = $this->db->connect()->prepare('select url from material where idmaterial = :id');
            $query->execute([
                'id'   => $id
            ]);

            while($row =  $query->fetch()){
                $archivo = $row['url'];
            }

            $query = $this->db->connect()->prepare('delete from material where idmaterial = :id');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from material_grupo where idmaterial = :id');
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

    function AsignarGrupo($datos)
    {
        try{
            $query = $this->db->connect()->prepare('insert into material_grupo (idmaterial, idgrupo)
            values (:idmaterial, :idgrupo) ');
            $query->execute([
                'idmaterial' => $datos['idmaterial'],
                'idgrupo'    => $datos['idgrupo']
            ]);
        
            return 'Grupo Asignado';

        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function GetMaterialByParticipante($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            m.* 
            FROM grupo_participante gp
            inner join material_grupo mg
            on mg.idgrupo = gp.idgrupo
            inner join material m
            on m.idmaterial = mg.idmaterial
            where gp.idparticipante = :idparticipante');
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