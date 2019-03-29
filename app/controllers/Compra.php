<?php
class Compra extends Controller
{
   /**
    * Registra nueva Compra
    *
    * Registra una Nueva Compra en la base de Datos
    *
    **/
   public function vRegistrar()
   {
        $mProveedor=new mProveedor;
        $proveedores=$mProveedor->GetList();
        $data=['Proveedores'=>$proveedores];
        $this->vista('Compra/vRegistrar', $data);
   } 
}

?>