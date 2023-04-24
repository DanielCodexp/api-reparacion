<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require 'vendor/autoload.php';

class Users
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
    function getToken()
    {
        $headers = apache_request_headers();
        //Validacion si esta autentiticado
        if (!isset($headers["Authorization"])) {
            Flight::halt(403, json_encode([
                "error" => 'Unauthenticated request',
                "status" => 'error'
            ]));
        }
        $authorization = $headers["Authorization"];
        $authorizationArray = explode(" ", $authorization);
        $token = $authorizationArray[1];
        $key = $_ENV['JWT_SECRET_KEY'];
        try {
            return JWT::decode($token, new key($key, 'HS256'));
        } catch (\Throwable $th) {
            Flight::halt(403, json_encode([
                "error" => $th->getMessage(),
                "status" => 'error'
            ]));
        }
    }

    function auth()
    {
        $username = Flight::request()->data->username;
        $password = Flight::request()->data->password;
        $query = $this->db->prepare("SELECT * FROM user where username = :username and password = :password");
        $query->execute([":username" => $username, ":password" => $password]);
        if ($query->rowCount() === 0) {
            Flight::halt(403, json_encode([
                "error" => "Not allowed",
                "status" => "error"
            ]));
        }
        $user = $query->fetch();
        $now = strtotime("now");
        $key = $_ENV['JWT_SECRET_KEY'];
        $payload = [
            'exp' => $now + 3600,
            'username' => $user['username'],
            'role' => $user['role']
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        $array = [
            "token" => $jwt,
            "username" => $user['username'],
            "role" => $user['role']
        ];

        Flight::json($array);
    }

    function validateToken()
    {
        $info = $this->getToken();
        $query = $this->db->prepare("SELECT * FROM user WHERE username = :username");
        $query->execute([":username" => $info->username]);
        $rows = $query->fetchColumn();
        return $rows;
    }

    function getAll()
    {
        // if (!$this->validateToken()) {
        //     Flight::halt(403, json_encode([
        //         "error" => 'Unauthorized',
        //         "status" => 'error'
        //     ]));
        // }
        // $validate = $this->validateToken();
        $query = $this->db->prepare("SELECT * FROM user");
        $query->execute();
        $data = $query->fetchAll();
        $array = [];
        foreach ($data as $row) {
            $array[] = [
                "id" => $row['id'],
                "username" => $row['username'],
                "role" => $row['role'],
                "name" => $row['name']
            ];
        }

        Flight::json([
            "total_rows" => $query->rowCount(),
            "rows" => $array,

            //  "validate" =>$validate

        ]);
    }

    function getId($username)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE username = :username");
        $query->execute([":username" => $username]);
        $data = $query->fetch();
        $array = [
            "username" => $data['username'],
            "role" => $data['role'],
            "name" => $data['name']
        ];
        Flight::json($array);
    }

    function new ()
    {
        $username = Flight::request()->data->username;
        $password = Flight::request()->data->password;
        $role = Flight::request()->data->role;
        $name = Flight::request()->data->name;
        $query = $this->db->prepare("INSERT INTO user (username, password, role, name) VALUES (:username, :password,
         :role, :name)");

        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if ($query->execute([":username" => $username, ":password" => $password, ":role" => $role, ":name" => $name])) {
            $array = [
                "data" => [
                    "id" => $this->db->lastInsertId(),
                    "username" => $username,
                    "password" => $password,
                    "role" => $role,
                    "name" => $name,

                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }

    function edit()
    {
        $id = Flight::request()->data->id;
        $username = Flight::request()->data->username;
        $password = Flight::request()->data->password;
        $role = Flight::request()->data->role;
        $name = Flight::request()->data->name;

        $query = $this->db->prepare("UPDATE user SET username = :username, password = :password, role = :role, name = :name WHERE id = :id");

        $array = [
            "error" => "Hubo un error al agregar los registros",
            "status" => "error"
        ];

        if ($query->execute([":username" => $username, ":password" => $password, ":role" => $role, ":name" => $name,  ":id" => $id])) {
            $array = [
                "data" => [

                    "id" => $id,
                    "username" => $username,
                    "password" => $password,
                    "role" => $role,
                    "name" => $name
                ],
                "status" => "success"
            ];
        }

        Flight::json($array);
    }

    function delete($username)
    {
        $query = $this->db->prepare("DELETE from user WHERE username = :username");
        if ($query->execute([":username" => $username])) {
            $array = [
                "data" => [
                    "username" => $username,
                ],
                "status" => "deleted"
            ];
        }
        Flight::json($array);
    }    
    

}
