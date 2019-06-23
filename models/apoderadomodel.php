<?PHP
include_once 'models/apoderado.php';

class ApoderadoModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function InsertaAlumnoApoderado($datos)
    {
        try{
            $idapoderado             = $datos['idapoderado'];
            $idparticipante          = $datos['idparticipante'];
            
            $con = $this->db->connect();
            $query = $con->prepare('insert into apoderado_alumno
            (idapoderado, idparticipante)
            values (:idapoderado, :idparticipante)');
            $query->execute([
                'idapoderado'           => $idapoderado,
                'idparticipante'        => $idparticipante
            ]);

            
            return "Registro Insertado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function RegistraApoderado($datos)
    {
        try{
            $nombres            = $datos['nombres'];
            $apellidos          = $datos['apellidos'];
            $correo             = $datos['correo'];
            $celular            = $datos['celular'];
            $dni                = $datos['dni'];
            $direccion          = $datos['direccion'];
            $fijo               = $datos['fijo'];
            $tipo               = $datos['tipo'];
            $encargado          = $datos['encargado'];

            $con = $this->db->connect();
            $query = $con->prepare('insert into
            apoderado (nombres, apellidos, celular, correo, dni, direccion, telefono_fijo, tipo, encargado_pagos)
            values (:nombres, :apellidos, :celular, :correo, :dni, :direccion, :fijo, :tipo, :encargado)');
            $query->execute([
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'celular'           => $celular,
                'correo'            => $correo,
                'dni'               => $dni,
                'direccion'         => $direccion,
                'fijo'              => $fijo,
                'tipo'              => $tipo,
                'encargado'         => $encargado
            ]);
            $idapoderado = $con->lastInsertId();

            $query = $this->db->connect()->prepare('insert into usuario (idparticipante, idtipo, nombres, apellidos, correo, usuario, clave)
            values (:idparticipante, :idtipo, :nombres, :apellidos, :correo, :usuario, MD5(:clave))');
            $query->execute([
                'idparticipante'    => $idapoderado,
                'idtipo'            => 'PDF',
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'correo'            => $correo,
                'usuario'           => $dni,
                'clave'             => $dni
            ]);



            return $idapoderado;
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

    public function VerificaDNI($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT count(idapoderado) as cantidad
            from apoderado
            where dni=:dni");
            $query->execute([
                'dni'  => $datos['dni']
            ]);

            while($row =  $query->fetch()){
                $items["data"][]  = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }

            return $items;

        }catch(PDOException $e){
            return [];
        }
    }

    public function ListaHijos($datos)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT distinct
            p.idparticipante,
            p.nombres,
            p.apellidos
            FROM apoderado_alumno aa
            inner join apoderado a
            on a.idapoderado = aa.idapoderado
            inner JOIN participantes p
            on p.idparticipante = aa.idparticipante
            WHERE 
            aa.idapoderado = 22 or 
            aa.idapoderado = 23");
            $query->execute([
                'idpadre'  => $datos['idpadre'],
                'idmadre'  => $datos['idmadre']
            ]);

            while($row =  $query->fetch()){
                $items["data"][]  = $row;
            }

            if(count($items) == 0){
                $items['data'] = "";
            }

            return $items;

        }catch(PDOException $e){
            return [];
        }
    }
}
?>