<?php

require 'vendor/autoload.php';

class Img
{
    private $db;
    function __construct()
    {
        Flight::register(
            'db',
            'PDO',
            array('mysql:host=' . $_ENV["DB_HOST"] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'])
        );
        $this->db = Flight::db();
    }

    function guardarImagenes() {
    
       $img = Flight::request()->data->img;
        
        $direccion = dirname(__DIR__) . "\assets\images\\";    
        $partes = explode(";base64,",$img);
         // Optine la primera parte del arreglo y lo divide para obtener el tipo de imagen
        $extension = explode('/',mime_content_type($img))[1];
        // decodifica la imagen en base 64
        $imagen_base64 = base64_decode($partes[1]);
        //ruta donde se guardo la imagen
        $file = $direccion . uniqid() . "." . $extension;
        //metodo para guardar la imagen 
        file_put_contents($file,$imagen_base64);
        //Quitar // que arroja la direccion
        $nuevadireccion = str_replace('\\','/',$file);

       
       
       
       Flight::json($nuevadireccion);
       
      }
      
}
