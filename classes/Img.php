<?php

require 'vendor/autoload.php';

class Img
{
    private $db;
    private $img;
    private $obs;
    private $id;
    function __construct()
    {
        Flight::register(
            'db',
            'PDO',
            array('mysql:host=' . $_ENV["DB_HOST"] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'])
        );
        $this->db = Flight::db();
    }

    function guardar()
    {
        $imagenes = Flight::request()->data;
        $imagePaths = [];
        $descriptions = [];
        foreach ($imagenes as $image) {
            $description = $image['des'];
            $base64Image = $image['img'];

            // Obtener la extensión de la imagen
            $extension = explode('/', mime_content_type($base64Image))[1];
            // Crear un nombre de archivo único para la imagen
            $filename = uniqid() . '.' . $extension;
            // Decodificar la imagen de base64 y guardarla en la carpeta de imágenes
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $filePath = dirname(__DIR__) . "\assets\images\\" . $filename;
            file_put_contents($filePath, $imageData);
            //Quitar // que arroja la direccion
            $nuevadireccion = str_replace('\\', '/', $filePath);
            // Agregar la ruta de la imagen al arreglo de rutas y la descripción al arreglo de descripciones
            array_push($imagePaths, $nuevadireccion);
            array_push($descriptions, $description);
        }
        Flight::json($descriptions);
        Flight::json($imagePaths);
        $this->img = implode(",", $imagePaths);
        $this->obs = implode(",", $descriptions);
        Flight::json($this->img);
        //     $this->idDes();
        //  $this->insert();
    }
    function idDes()
    {

        $query = $this->db->prepare('SELECT nIdDiag FROM tbdiagdet ORDER BY nIdDiag DESC LIMIT 1');
        $query->execute();
        $data = $query->fetch();
        if ($data && isset($data['nIdDiag'])) {
            if ($data['nIdDiag'] > 0) {
                $this->id = $data['nIdDiag'] + 1;
            } else {
                $this->id = 1;
            }
        } else {
            $this->id = 1;
        }

        Flight::json($this->id);
    }
    function insert()
    {
        $nFotDiag = Flight::request()->data->nFotDiag;
        $cNomDiag = Flight::request()->data->cNomDiag;
        $cObsDiag = Flight::request()->data->cObsDiag;
        $nIdDiag = Flight::request()->data->nIdDiag;
        $query = $this->db->prepare("INSERT INTO tbdiagdet (nFotDiag, cNomDiag, cObsDiag, nIdDiag) 
        VALUES (:nFotDiag, :cNomDiag, :cObsDiag, :nIdDiag)");
        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];
        if (
            $query->execute([
                ":nFotDiag" => "1",
                ":cNomDiag" => $this->img,
                ":cObsDiag" => $this->obs,
                ":nIdDiag" => $this->id,
            ])
        ) {
            $array = [
                "data" => [
                    "nIntDiag" => $this->db->lastInsertId(),
                    ":nFotDiag" => $nFotDiag,
                    ":cNomDiag" => $cNomDiag,
                    ":cObsDiag" => $cObsDiag,
                    ":nIdDiag" => $nIdDiag,
                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }

    function edit($nIntDiag)
    {
        // $nIntDiag = Flight::request()->data->nIntDiag;
        $nFotDiag = Flight::request()->data->nFotDiag;
        $cNomDiag = Flight::request()->data->cNomDiag;
        $cObsDiag = Flight::request()->data->cObsDiag;
        $nIdDiag = Flight::request()->data->nIdDiag;

        $query = $this->db->prepare("UPDATE tbdiagdet SET nFotDiag = :nFotDiag, cNomDiag = :cNomDiag, cObsDiag = :cObsDiag, nIdDiag = :nIdDiag WHERE nIntDiag = :nIntDiag");
        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];
        if (
            $query->execute([
                "nIntDiag" => $nIntDiag,
                ":nFotDiag" => $nFotDiag,
                ":cNomDiag" => $cNomDiag,
                ":cObsDiag" => $cObsDiag,
                ":nIdDiag" => $nIdDiag
            ])
        ) {
            $array = [
                "data" => [
                    "nIntDiag" => $nIntDiag,
                    ":nFotDiag" => $nFotDiag,
                    ":cNomDiag" => $cNomDiag,
                    ":cObsDiag" => $cObsDiag,
                    ":nIdDiag" => $nIdDiag,
                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }


    function guardar_imagenes()
    { 
        $this->idDes();
        $imagenes = Flight::request()->data;
        foreach ($imagenes as $imagen) {
            // Obtener la descripción de la imagen y la imagen en base 64
            $cObsDiag = $imagen['des'];
            $base64Image = $imagen['img'];
            // Obtener la extensión de la imagen
            $extension = explode('/', mime_content_type($base64Image))[1];
            // Crear un nombre de archivo único para la imagen
            $filename = uniqid() . '.' . $extension;
            // Decodificar la imagen de base64 y guardarla en la carpeta de imágenes
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $filePath = dirname(__DIR__) . "\assets\images\\" . $filename;
            file_put_contents($filePath, $imageData);
            //Quitar // que arroja la direccion
            $cNomDiag = str_replace('\\', '/', $filePath);
            
            $nFotDiag = Flight::request()->data->nFotDiag;
            $nIdDiag = Flight::request()->data->nIdDiag;
            $query = $this->db->prepare("INSERT INTO tbdiagdet (nFotDiag, cNomDiag, cObsDiag, nIdDiag) 
            VALUES (:nFotDiag, :cNomDiag , :cObsDiag, :nIdDiag)");
            $array = [
                "error" => "Hubo un error al agregar los registros",
                "status" => "error"
            ];
            if (
                $query->execute([
                    ":nFotDiag" => "1",
                    ":cNomDiag" => $cNomDiag,
                    ":cObsDiag" => $cObsDiag,
                    ":nIdDiag" => $this->id,
                  //":nIdDiag" => "2",
                ])
            ) {
                $array = [
                    "data" => [
                        "nIntDiag" => $this->db->lastInsertId(),
                        ":nFotDiag" => $nFotDiag,
                        ":cNomDiag" => $cNomDiag,
                        ":cObsDiag" => $cObsDiag,
                        ":nIdDiag" => $nIdDiag,
                    ],
                    "status" => "success"
                ];
            }

            Flight::json($array);
        }
    }
    function getByID($nIdDiag)
    {
        $query = $this->db->prepare("SELECT * FROM tbdiagdet WHERE nIdDiag = :nIdDiag");
        $query->execute([":nIdDiag" => $nIdDiag]);
        $img = $query->fetchAll();
        $array = [];
        foreach ($img as $row) {
            $array[] = [
                "nIntDiag" => $row['nIntDiag'],
                "nFotDiag" => $row['nFotDiag'],
                "cNomDiag" => $row['cNomDiag'],
                "cObsDiag" => $row['cObsDiag'],
                "nIdDiag" => $row['nIdDiag'],
            ];
        }
        Flight::json( $array);
    }
}
