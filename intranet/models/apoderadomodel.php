<?PHP
include_once 'models/apoderado.php';

class ApoderadoModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function RegistraApoderado($datos)
    {
        try{
            $idparticipante     = $datos['idpostulante'];
            $nombres            = $datos['nombres'];
            $apellidos          = $datos['apellidos'];
            $correo             = $datos['correo'];
            $celular            = $datos['celular'];
            $id_ap              = "";
        
            $query = $this->db->connect()->prepare('call inserta_apoderado (:idparticipante, :nombres, :apellidos, :celular, :correo)');
            $query->execute([
                'idparticipante'    => $idparticipante,
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'celular'           => $celular,
                'correo'            => $correo
            ]);

            while($row =  $query->fetch()){
                $id_ap     = $row['lid'];
            }

            return $id_ap;
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function ActualizaApoderado($datos)
    {
        try{
            $id         = $datos['id'];
            $nombres    = $datos['nombres'];
            $apellidos  = $datos['apellidos'];
            $correo     = $datos['correo'];
            $celular    = $datos['celular'];
            
            $query = $this->db->connect()->prepare('update apoderado set nombres= :nombres, apellidos = :apellidos, celular = :celular, correo = :correo where idapoderado=:id');
            $query->execute([
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'celular'           => $celular,
                'correo'            => $correo,
                'id'                => $id
            ]);

            return "Actualizado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function GetApoderado($id)
    {
        $item = new Apoderado();
        try{
            $query = $this->db->connect()->prepare("
            SELECT a.* FROM apoderado_alumno aa 
            inner join apoderado a
            on a.idapoderado = aa.idapoderado
            WHERE a.idapoderado=:id
            and a.estado=1");
            $query->execute([
                'id'  => $id
            ]);

            while($row =  $query->fetch()){
                $item->idapoderado  = $row['idapoderado'];
                $item->nombres      = $row['nombres'];
                $item->apellidos    = $row['apellidos'];
                $item->correo       = $row['correo'];
                $item->celular      = $row['celular'];
            }

            return $item;
        }catch(PDOException $e){
            return [];
        }
    }

    public function GetApoderadosByAlumno($id)
    {
        $items = [];

        $query = $this->db->connect()->prepare("SELECT
        a.idapoderado,
        al.id_apoderadoalumno,
        a.nombres,
        a.apellidos,
        a.correo, 
        a.celular
        from apoderado a
        inner join apoderado_alumno al
        on al.idapoderado = a.idapoderado
        where al.idparticipante = :id");
        try{
            $query->execute([
                'id' => $id
            ]);
            while($row =  $query->fetch()){
                $items["data"][]  = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return null;
        }
    }

    public function EliminaApoderado($id)
    {
        $query = $this->db->connect()->prepare('delete from apoderado where idapoderado = :id');
        $query->execute([
            'id'  => $id
        ]);
    }
}
?>