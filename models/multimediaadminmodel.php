<?PHP
class MultimediaAdminModel extends Model
{
    function __construct(){
        parent::__construct();
    }

    public function ListaMultimedia($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            m.idmultimedia,
            m.titulo,
            m.url,
            COALESCE(concat(d.nombres, ' ', d.apellidos), '-') as docente,
            COALESCE(concat(p.nombres, ' ', p.apellidos), '-') as alumno,
            COALESCE(g.descripcion, 'SIN GRUPO ALUMNO') as grupo_alumno,
            COALESCE(GROUP_CONCAT(gg.descripcion), 'SIN GRUPO DOCENTE') as grupo_docente
            FROM multimedia m
            left join multimedia_docente md
            on m.idmultimedia = md.idmultimedia
            left join docente d
            on d.iddocente = md.iddocente
            left join multimedia_alumno ma
            on ma.idmultimedia = m.idmultimedia
            left join participantes p
            on p.idparticipante = ma.idalumno
            left join multimedia_grupo mg
            on mg.idmultimedia = m.idmultimedia
            left join grupo_participante gp
            on gp.idparticipante = ma.idalumno
            left join grupo g
            on gp.idgrupo = g.idgrupo
            left join grupo gg
            on mg.idgrupo = gg.idgrupo
            group by gg.idgrupo");
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

    function EliminaMultimedia($id)
    {
        try{
            $query = $this->db->connect()->prepare('delete from multimedia where idmultimedia = :id;');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from multimedia_grupo where idmultimedia = :id;');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from multimedia_docente where idmultimedia = :id;');
            $query->execute([
                'id'   => $id
            ]);

            $query = $this->db->connect()->prepare('delete from multimedia_alumno where idmultimedia = :id;');
            $query->execute([
                'id'   => $id
            ]);

            return "Eliminado";    
            
        }catch(PDOException $e){
            return $e->getMessage();
            
        }
    }
}
?>