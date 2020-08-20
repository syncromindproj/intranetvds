<?PHP
class Horario_CorosModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function GetHorariosAdmin()
    {
        $items = [];

        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            h.descripcion,
            hd.*,
            hd.dia as dia_panel,
            DATE_FORMAT(hd.dia,'%d/%m/%Y') as dia,
            te.color,
            g.descripcion as grupo
            from horario h
            inner join horario_detalle hd
            on hd.idhorario = h.idhorario
            inner join tipo_evento te
            on te.id = h.tipo
            inner join grupo g
            on g.idgrupo = h.idgrupo
            order by hd.dia asc");
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

    public function GetEventosAdmin()
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare('
            SELECT 
            e.titulo,
            e.descripcion,
            DATE_FORMAT(e.fecha,"%d/%m/%Y") as fecha,
            e.hora,
            fecha as fecha_panel
            FROM evento e');
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