<?php

require 'vendor/autoload.php';


class Diagben
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

    function getAll()
    {
        $query = $this->db->prepare("SELECT * FROM tbDiagDet");
        $query->execute();
        $data = $query->fetchAll();
        $tbDiagDet = [];
        foreach ($data as $row) {
            $tbDiagDet[] = [
                "nIntDiag" => $row['nIntDiag'],
                "nFotDiag" => $row['nFotDiag'],
                "cNomDiag" => $row['cNomDiag'],
                "cObsDiag" => $row['cObsDiag'],
                "nIdDiag" => $row['nIdDiag'],
            ];
        }


        $query = $this->db->prepare("SELECT * FROM tbDiagGen");
        $query->execute();
        $data = $query->fetchAll();
        $array = [];
        foreach ($data as $row) {
            $array[] = [
                "nIdDiag" => $row['nIdDiag'],
                "cCveMec" => $row['cCveMec'],
                "cCveRea" => $row['cCveRea'],
                "cCveSup" => $row['cCveSup'],
                "cDesCar" => $row['cDesCar'],
                "cDesTras" => $row['cDesTras'],
                "cMcaMot" => $row['cMcaMot'],
                "cObsDiag" => $row['cObsDiag'],
                "cDesHP" => $row['cDesHP'],
                "dtFecReg" => $row['dtFecReg'],
                "dtHorReg" => $row['dtHorReg'],
                "cDesFall" => $row['cDesFall'],
                "nCveEmp" => $row['nCveEmp'],
                "nCveSrv" => $row['nCveSrv'],
                "nIdeUni" => $row['nIdeUni'],
                "cTipCar" => $row['cTipCar'],
                "cTipMot" => $row['cTipMot'],
                "nModUni" => $row['nModUni'],
               // "tbDiagDet" => $tbDiagDet
            ];
        }

        Flight::json([
            "reports" => $array,
        ]);
    }

    function createDiagGen()
    {
        $cCveMec = Flight::request()->data->cCveMec;
        $cCveRea = Flight::request()->data->cCveRea;
        $cCveSup = Flight::request()->data->cCveSup;
        $cDesCar = Flight::request()->data->cDesCar;
        $cDesTras = Flight::request()->data->cDesTras;
        $cMcaMot = Flight::request()->data->cMcaMot;
        $cObsDiag = Flight::request()->data->cObsDiag;
        $cDesHP = Flight::request()->data->cDesHP;
        $dtFecReg = Flight::request()->data->dtFecReg;
        $dtHorReg = Flight::request()->data->dtHorReg;
        $cDesFall = Flight::request()->data->cDesFall;
        $nCveEmp = Flight::request()->data->nCveEmp;
        $nCveSrv = Flight::request()->data->nCveSrv;
        $nIdeUni = Flight::request()->data->nIdeUni;
        $cTipMot = Flight::request()->data->cTipMot;
        $cTipCar = Flight::request()->data->cTipCar;
        $nModUni = Flight::request()->data->nModUni;

        $query = $this->db->prepare("INSERT INTO tbDiagGen (cCveMec, cCveRea, cCveSup, cDesCar, cDesTras, cMcaMot, cObsDiag, cDesHP, dtFecReg, dtHorReg, cDesFall, nCveEmp, nCveSrv, nIdeUni, cTipMot, cTipCar, nModUni) 
        VALUES (:cCveMec, :cCveRea, :cCveSup, :cDesCar, :cDesTras, :cMcaMot, :cObsDiag, :cDesHP, :dtFecReg, :dtHorReg, :cDesFall, :nCveEmp, :nCveSrv, :nIdeUni, :cTipMot, :cTipCar, :nModUni)");


        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if (
            $query->execute([
                ":cCveMec" => $cCveMec,
                ":cCveRea" => $cCveRea,
                ":cCveSup" => $cCveSup,
                ":cDesCar" => $cDesCar,
                ":cDesTras" => $cDesTras,
                ":cMcaMot" => $cMcaMot,
                ":cObsDiag" => $cObsDiag,
                ":cDesHP" => $cDesHP,
                ":dtFecReg" => $dtFecReg,
                ":dtHorReg" => $dtHorReg,
                ":cDesFall" => $cDesFall,
                ":nCveEmp" => $nCveEmp,
                ":nCveSrv" => $nCveSrv,
                ":nIdeUni" => $nIdeUni,
                ":cTipMot" => $cTipMot,
                ":cTipCar" => $cTipCar,
                ":nModUni" => $nModUni,


            ])
        ) {
            $array = [
                "data" => [
                    "nIdDiag" => $this->db->lastInsertId(),
                    "cCveMec" => $cCveMec,
                    "cCveRea" => $cCveRea,
                    "cCveSup" => $cCveSup,
                    "cDesCar" => $cDesCar,
                    "cDesTras" => $cDesTras,
                    "cMcaMot" => $cMcaMot,
                    "cObsDiag" => $cObsDiag,
                    "cDesHP" => $cDesHP,
                    "dtFecReg" => $dtFecReg,
                    "dtHorReg" => $dtHorReg,
                    "cDesFall" => $cDesFall,
                    "nCveEmp" => $nCveEmp,
                    "nCveSrv" => $nCveSrv,
                    "nIdeUni" => $nIdeUni,
                    "cTipMot" => $cTipMot,
                    "cTipCar" => $cTipCar,
                    "nModUni" => $nModUni,

                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }


    function createDiagDet()
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
                ":nFotDiag" => $nFotDiag,
                ":cNomDiag" => $cNomDiag,
                ":cObsDiag" => $cObsDiag,
                ":nIdDiag" => $nIdDiag,
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

    function getByID($nIdDiag)
    {
        $query = $this->db->prepare("SELECT * FROM tbdiagdet WHERE nIdDiag = :nIdDiag");
        $query->execute([":nIdDiag" => $nIdDiag]);
        $img = $query->fetch();
        $url = explode(",", $img['cNomDiag']);
        $commit = explode(",", $img['cObsDiag']);
        $imagenes = array();
            if (count( $url) == count($commit )) {
              for ($i = 0; $i < count( $url); $i++) {
                $objeto = new stdClass();
                $objeto->img=  $url[$i];
                $objeto->des = $commit [$i];
                array_push($imagenes, $objeto);
              }
            }
        $query = $this->db->prepare("SELECT * FROM tbDiagGen WHERE nIdDiag = :nIdDiag");
        $query->execute([":nIdDiag" => $nIdDiag]);
        $principal = $query->fetch();

        $array[] = [
            "nIdDiag" => $principal['nIdDiag'],
            "cCveMec" => $principal['cCveMec'],
            "cCveRea" => $principal['cCveRea'],
            "cCveSup" => $principal['cCveSup'],
            "cDesCar" => $principal['cDesCar'],
            "cDesTras" => $principal['cDesTras'],
            "cMcaMot" => $principal['cMcaMot'],
            "cObsDiag" => $principal['cObsDiag'],
            "cDesHP" => $principal['cDesHP'],
            "dtFecReg" => $principal['dtFecReg'],
            "dtHorReg" => $principal['dtHorReg'],
            "cDesFall" => $principal['cDesFall'],
            "nCveEmp" => $principal['nCveEmp'],
            "nCveSrv" => $principal['nCveSrv'],
            "nIdeUni" => $principal['nIdeUni'],
            "cTipCar" => $principal['cTipCar'],
            "cTipMot" => $principal['cTipMot'],
            "nModUni" => $principal['nModUni'],
            "tbDiagDet" => $imagenes
        ];

        Flight::json($array);
    }
}
