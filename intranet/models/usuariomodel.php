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
            idusuario,
            usuario,
            nombres
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
}
?>