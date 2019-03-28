<?php
class mVenta 
{
    private $db;
    public function __construct() {
        $this->db=new Database;
    }

    /**
     * Lista todas las ventas
     *
     * Devuelve una lista de registros de venta de la base de datos
     *
     * @param Int $offset Inicio paginado
     * @param Int $limit Fin paginado
     * @return Array arreglo de objetos de tipo venta
     **/
    
    public function Listar($offset, $limit)
    {
        $query = "SELECT *.Venta, Proveedor.nombre AS nombre_proveedor, CONCAT(Usuario.nombre, ' ',Usuario.apellidos) AS nombre_usuario 
                  FROM Compra 
                  INNER JOIN Proveedor ON Proveedor.id_proveedor = Compra.proveedor
                  INNER JOIN Usuario ON Usuario.id_usuario = Compra.usuario
                  ORDER BY nro DESC
                  LIMIT :offset, :limit";
        $this->db->prepare($query);
        $this->db->bindParam(":offset", $offset);
        $this->db->bindParam(":limit", $limit);
        
        return $this->db->getRegistros();
    }

    //Insertar
    public function Insertar($venta)
    {
        $resp;
        $query="INSERT INTO Venta(nro, fecha, usuario, cliente, factura, total)
                VALUES (:nro, :fecha, :usuario, :cliente, :factura, :total)";
        $this->db->prepare($query);
        $this->db->bindParam(':nro',$venta->nro);
        $this->db->bindParam(':fecha',$venta->fecha);
        $this->db->bindParam(':usuario',$venta->esAdmin); //preguntar que chingados hace esto
        $this->db->bindParam(':cliente',$venta->cliente);
        $this->db->bindParam(':factura',$venta->factura);
        $this->db->bindParam(':total',$venta->total);
        
        $resp['status']=$this->db->execute();
        $resp['error']=$this->db->error;
        return $resp;
    }

    //Actualizar
    public function Actualizar($venta)
    {
        $resp;
        $query="UPDATE Venta
                SET nro=:nro, fecha=:fecha, usuario=:usuario, cliente=:cliente, factura=:factura, total=:total
                WHERE id_venta=:id_venta";
        $this->db->prepare($query);
        $this->db->bindParam(':nro',$venta->nro);
        $this->db->bindParam(':fecha',$venta->fecha);
        $this->db->bindParam(':usuario',$venta->usuario);
        $this->db->bindParam(':cliente',$venta->cliente);
        $this->db->bindParam(':factura',$venta->factura);
        $this->db->bindParam(':total',$venta->total);
        $this->db->bindParam(':id_venta',$venta->id_venta);
        $resp['status']= $this->db->execute();
        $resp['error']=$this->db->error;
        return $resp;
    }  
    
    //Eliminar
    public function Eliminar($id)
    {
        $resp;
        $query="DELETE FROM Venta 
                WHERE id_venta=:id_venta";
        $this->db->prepare($query);
        $this->db->bindParam(':id_venta', $id);
        $resp['status']=$this->db->execute();
        $resp['error']=$this->db->error;
        return $resp;
    }
}

?>