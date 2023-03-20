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
                "nCveEmp" => $row['nCveEmp'],
                "nCveSrv" => $row['nCveSrv'],
                "nIdUni" => $row['nIdUni'],
                "cCveUni" => $row['cCveUni'],
                "cObsDiag" => $row['cObsDiag'],
                "cCveRea" => $row['cCveRea'],
                "cCveMec" => $row['cCveMec'],
                "cCveSup" => $row['cCveSup'],
                "dtFecReg" => $row['dtFecReg'],
                "nEdoDig" => $row['nEdoDig'],
                "tbDiagDet" => $tbDiagDet
            ];
        }

        Flight::json([
            "total_rows" => $query->rowCount(),
            "rows" => $array,
        ]);

    }
 



}