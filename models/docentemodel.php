<?PHP
class DocenteModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function GetDocentes(){
        $items = [];

        try{
            $query = $this->db->connect()->query("select * from docente order by apellidos asc");

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

    public function VerDocente($id){
        $items = [];

        try{
            $query = $this->db->connect()->prepare("select * from docente where iddocente = :id");
            $query->execute([
                'id' => $id
            ]);

            while($row =  $query->fetch()){
                $items[] = $row;
            }

            if(count($items) == 0){
                $items = "";
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function RegistraDocente($datos)
    {
        try{
            $nombres            = $datos['nombres'];
            $apellidos          = $datos['apellidos'];
            $correo             = $datos['correo'];
            $celular            = $datos['celular'];
            $dni                = $datos['dni'];
        
            $query = $this->db->connect()->prepare('insert into docente (nombres, apellidos, correo, celular, dni) values (:nombres, :apellidos, :correo, :celular, :dni)');
            $query->execute([
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'correo'            => $correo,
                'celular'           => $celular,
                'dni'               => $dni
            ]);

            $query = $this->db->connect()->prepare("insert into usuario (idtipo, nombres, apellidos, usuario, clave)
            values (:idtipo, :nombres, :apellidos, :dni, :clave)") ;
            
            $query->execute([
                'idtipo'            => 'DOC',
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'dni'               => $dni,
                'clave'             => MD5($dni)
            ]);

            return "Registro ingresado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function ActualizaDocente($datos)
    {
        try{
            $id                 = $datos['id'];
            $nombres            = $datos['nombres'];
            $apellidos          = $datos['apellidos'];
            $correo             = $datos['correo'];
            $celular            = $datos['celular'];
            $dni                = $datos['dni'];
            
            $query = $this->db->connect()->prepare('update docente set nombres = :nombres, apellidos = :apellidos, correo = :correo, celular = :celular, dni = :dni where iddocente = :id');
            $query->execute([
                'nombres'           => $nombres,
                'apellidos'         => $apellidos,
                'correo'            => $correo,
                'celular'           => $celular,
                'dni'               => $dni,
                'id'                => $id
            ]);

            return "Registro actualizado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function ActualizaImageDocente($id, $imagen)
    {
        try{
            $query = $this->db->connect()->prepare('update docente set imagen = :imagen where iddocente = :id');
            $query->execute([
                'imagen'            => $imagen,
                'id'                => $id
            ]);

            return "Registro actualizado";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }


    public function EliminaDocente($id)
    {
        $query = $this->db->connect()->prepare('delete from docente where iddocente = :id');
        $query->execute([
            'id'  => $id
        ]);
    }
}
?>