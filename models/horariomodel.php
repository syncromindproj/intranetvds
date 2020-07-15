<?PHP
class HorarioModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function GetHorarios()
    {
        $items = [];

        try{
            /*$query = $this->db->connect()->query("SELECT 
            g.idgrupo, g.descripcion as grupo, COALESCE(h.descripcion,'SIN HORARIO ASIGNADO', h.descripcion) as horario
            FROM grupo g
            left join horario h
            on g.idgrupo = h.idgrupo
            order by g.descripcion asc");*/
            $query = $this->db->connect()->query("
            SELECT h.idhorario, g.descripcion as grupo, h.descripcion, h.tipo
            FROM horario h 
            inner join grupo g
            on g.idgrupo = h.idgrupo");

            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function GetHorarioDetalle($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT idhorario_detalle, idhorario, 
            DATE_FORMAT(dia,'%d/%m/%Y') as dia,hora_inicio, hora_fin from horario_detalle where idhorario = :idhorario order by dia asc");
            $query->execute([
                'idhorario'       => $datos['idhorario']
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

    public function GetHorarioParticipante($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            h.descripcion,
            hd.*,
            hd.dia as dia_panel,
            DATE_FORMAT(hd.dia,'%d/%m/%Y') as dia,
            te.color
            from participantes p
            inner join grupo_participante gp
            on p.idparticipante= gp.idparticipante
            inner join horario h
            on h.idgrupo = gp.idgrupo
            inner join horario_detalle hd
            on hd.idhorario = h.idhorario
            inner join tipo_evento te
            on te.id = h.tipo
            where p.idparticipante = :idparticipante
            order by hd.dia asc");
            $query->execute([
                'idparticipante' => $datos['idparticipante']
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

    public function GetHorariobyApoderado($datos)
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            h.descripcion,
            hd.*,
            hd.dia as dia_panel,
            DATE_FORMAT(hd.dia,'%d/%m/%Y') as dia,
            te.color
            from participantes p
            inner join grupo_participante gp
            on p.idparticipante= gp.idparticipante
            inner join horario h
            on h.idgrupo = gp.idgrupo
            inner join horario_detalle hd
            on hd.idhorario = h.idhorario
            inner join tipo_evento te
            on te.id = h.tipo
            where p.idparticipante in (select idparticipante from apoderado_alumno where idapoderado=:idapoderado)
            order by hd.dia asc");
            $query->execute([
                'idapoderado' => $datos['idparticipante']
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

    public function InsertaHorario($datos)
    {
        try{
            $query = $this->db->connect()->prepare('insert into horario (idgrupo, descripcion, tipo) values (:idgrupo, :descripcion, :tipo)');
            $query->execute([
                'idgrupo'       => $datos['idgrupo'],
                'descripcion'   => $datos['descripcion'],
                'tipo'          => $datos['tipo']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        } 
    }

    public function AsignarHorario($datos)
    {
        try{
            $query = $this->db->connect()->prepare('insert into horario_detalle (idhorario, dia, hora_inicio, hora_fin) values (:idhorario, :dia, :hora_inicio, :hora_final)');
            $query->execute([
                'idhorario'     => $datos['idhorario'],
                'dia'           => $datos['dia'],
                'hora_inicio'   => $datos['hora_inicio'],
                'hora_final'    => $datos['hora_final']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        } 
    }

    public function EliminarDetalle($datos)
    {
        try{
            $query = $this->db->connect()->prepare('delete from horario_detalle where idhorario_detalle = :idhorario_detalle');
            $query->execute([
                'idhorario_detalle'     => $datos['id']
            ]);
        }catch(PDOException $e){
            return $e->getCode();
        } 
    }

    public function EliminaHorario($datos)
    {
        $query = $this->db->connect()->prepare('delete from horario_detalle where idhorario=:idhorario');
        $query->execute([
            'idhorario'  => $datos['idhorario']
        ]);

        $query = $this->db->connect()->prepare('delete from horario where idhorario=:idhorario');
        $query->execute([
            'idhorario'  => $datos['idhorario']
        ]);
    }
}
?>