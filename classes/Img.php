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

    function guardarImagenes($json) {
        // $carpeta = "imagenes/"; // ruta de la carpeta donde se guardarán las imágenes
        // $urls = array(); // arreglo donde se almacenarán las URLs de las imágenes guardadas
      
        // foreach($imagenes as $imagen) {
        //   $nombreArchivo = uniqid() . ".png"; // generamos un nombre de archivo único para evitar conflictos
        //   $rutaArchivo = $carpeta . $nombreArchivo;
          
        //   // decodificamos la imagen en base64 y la guardamos en el archivo correspondiente
        //   $archivo = fopen($rutaArchivo, "wb");
        //   fwrite($archivo, base64_decode($imagen));
        //   fclose($archivo);
          
        //   // agregamos la URL de la imagen guardada al arreglo de URLs
        //   $urls[] = "https://tudominio.com/" . $rutaArchivo; // reemplaza "tudominio.com" con el nombre de tu sitio web
        // }
        
        // // guardamos las URLs en un archivo JSON
        // $json = json_encode($urls);
        // file_put_contents("urls.json", $json);
        
        // return $urls; // retornamos el arreglo de URLs


        $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
    
        $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
        
        $nombre = $params->nombre;
        $nombreArchivo = $params->nombreArchivo;
        $archivo = $params->base64textString;
        $archivo = base64_decode($archivo);
        
        $filePath = $_SERVER['DOCUMENT_ROOT']."/PruebasAngular/".$nombreArchivo;
        file_put_contents($filePath, $archivo);
        
        
        class Result {}
        // GENERA LOS DATOS DE RESPUESTA
        $response = new Result();
        
        // $response->resultado = 'OK';
        // $response->mensaje = 'SE SUBIO EXITOSAMENTE';
        
        header('Content-Type: application/json');
        echo json_encode($response); // MUESTRA EL JSON GENERADO */
       



      }
      
}
