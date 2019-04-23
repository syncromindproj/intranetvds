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
            $dni                = $datos['dni'];
            $direccion          = $datos['direccion'];
            $fijo               = $datos['fijo'];
            $id_ap              = "";
        
            $query = $this->db->connect()->prepare('call inserta_apoderado (:idparticipante, :nombres, :apellidos, :celular, :correo, :dni, :direccion, :fijo)');
            $query->execute([
                'idparticipante'    => $idparticipante,
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'celular'           => $celular,
                'correo'            => $correo,
                'dni'               => $dni,
                'direccion'         => $direccion,
                'fijo'              => $fijo
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
            $dni        = $datos['dni'];
            $direccion  = $datos['direccion'];
            $fijo       = $datos['fijo'];
            $pagos      = $datos['pagos'];
            
            $query = $this->db->connect()->prepare('update apoderado set nombres= :nombres, 
            apellidos = :apellidos, celular = :celular, correo = :correo, dni = :dni, direccion = :direccion,
            telefono_fijo = :telefono_fijo, encargado_pagos = :encargado_pagos where idapoderado=:id');
            $query->execute([
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'celular'           => $celular,
                'correo'            => $correo,
                'dni'               => $dni,
                'direccion'         => $direccion,
                'telefono_fijo'     => $fijo,
                'encargado_pagos'   => $pagos,
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
                $item->idapoderado      = $row['idapoderado'];
                $item->nombres          = $row['nombres'];
                $item->apellidos        = $row['apellidos'];
                $item->correo           = $row['correo'];
                $item->celular          = $row['celular'];
                $item->dni              = $row['dni'];
                $item->direccion        = $row['direccion'];
                $item->telefono_fijo    = $row['telefono_fijo'];
                $item->encargado_pagos  = $row['encargado_pagos'];
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
        a.celular,
        (CASE when a.encargado_pagos = 0 then 'NO' when  a.encargado_pagos = 1 then 'SI' end) as encargado_pagos
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