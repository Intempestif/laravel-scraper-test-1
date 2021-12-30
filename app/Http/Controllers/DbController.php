<?php

namespace App\Http\Controllers;

// import PDO
use PDO;
use PDOException;

use Illuminate\Http\Request;

class DbController extends Controller
{
    public function connect(){

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "decathlon";
    
        // * connexion à la base de données
    
        try 
        {
    
            $db = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8mb4', $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        } catch (PDOException $e) {
    
            echo "Connexion à la base de donnée échouée : ". $e->getMessage();
    
        }

        return $db;

    }
}
