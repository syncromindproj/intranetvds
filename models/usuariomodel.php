<?php
class UsuarioModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function Login($usuario, $clave)
    {
        $items = [];
        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            *
            FROM usuario
            WHERE usuario = :usuario
            AND clave = :clave
            and estado = 1");
            $query->execute([
                'usuario'  => $usuario,
                'clave'  => MD5($clave)
            ]);
            
            while($row =  $query->fetch()){
                $items['data'][] = $row;
            }

            if(count($items) == 0){
                $items['data']['estado'] = "error_datos";
            }else{
                $items['data']['estado'] = "OK";
            }
            
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function ObtieneTipo($usuario)
    {
        $idtipo = "";
        try{
            $query = $this->db->connect()->prepare("
            SELECT 
            idtipo
            FROM usuario
            WHERE usuario = :usuario
            and estado = 1");
            $query->execute([
                'usuario'  => $usuario
            ]);
            
            while($row =  $query->fetch()){
               $idtipo = $row['idtipo'];
            }

            return $idtipo;
        }catch(PDOException $e){
            return [];
        }
    }

    public function ActualizaAprobacionReglamento($usuario)
    {
        try{
            $query = $this->db->connect()->prepare("
            update usuario
            set reglamento=1
            WHERE idusuario = :usuario");
            $query->execute([
                'usuario'  => $usuario
            ]);
            
            return "OK";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function ActualizaAprobacionPagos($usuario)
    {
        try{
            $query = $this->db->connect()->prepare("
            update usuario
            set pagos=1
            WHERE idusuario = :usuario");
            $query->execute([
                'usuario'  => $usuario
            ]);
            
            return "OK";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }

    public function CambiarClave($datos)
    {
        try{
            $query = $this->db->connect()->prepare("
            update usuario
            set clave=MD5(:clave)
            WHERE idparticipante = :idparticipante and idtipo='PDF'");
            $query->execute([
                'clave'             => $datos["clave"],
                'idparticipante'    => $datos["id"]
            ]);
            
            return "OK";
        }catch(PDOException $e){
            return $e->getCode();
        }
    }
}
?>