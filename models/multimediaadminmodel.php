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
            select
            COALESCE(m.idmultimedia, 'AÚN NO HA PUBLICADO') AS idmultimedia,
            COALESCE(m.titulo, 'AÚN NO HA PUBLICADO') as titulo,
            COALESCE(m.url, 'AÚN NO HA PUBLICADO') as url,
            g.descripcion as grupo,
            COALESCE(concat(d.nombres, ' ', d.apellidos), '-') as docente,
            COALESCE(concat(p.nombres, ' ', p.apellidos), '-') as alumno,
            COALESCE(m.comentario, 'AÚN NO HA PUBLICADO') as comentario,
            COALESCE(m.aprobadO, 'AÚN NO HA PUBLICADO') as aprobado
            from participantes p
            left join multimedia_alumno ma
            on ma.idalumno = p.idparticipante
            left join multimedia m
            on m.idmultimedia = ma.idmultimedia
            left join grupo_participante gp
            on gp.idparticipante = p.idparticipante
            left join grupo g
            on g.idgrupo = gp.idgrupo
            left join multimedia_docente md
            on md.idmultimedia = m.idmultimedia
            left join docente d
            on d.iddocente = md.iddocente
            where p.estado = 1");
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