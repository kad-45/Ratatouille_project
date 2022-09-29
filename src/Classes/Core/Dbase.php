<?php

namespace App\Classes\Core;
use PDO;
use PDOException;

class Dbase extends PDO
{
    private static $instance;
    
    
    /**
     * PDO::__construct — Crée une instance PDO qui représente une connexion à la base de donnée.
     *$dsn Le Data Source Name, ou DSN, qui contient les informations requises pour se connecter à la base de donnée.
     *PDO::setAttribute — Configure un attribut PDO du gestionnaire de base de données
     */

    private function __construct(){

        $dsn = 'mysql:dbname='.DATABASE . ';host=' .HOST;
        try{

            parent::__construct($dsn, USER, PWD);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->exec('SET NAMES utf8');
        }catch(PDOException $e){
            die($e->getMessage());
        }

    }
    
    /**
     * Cette méthode permet d'instancier une seul fois la classe Dbase:patron de conception singleton
     */
    
    public static function getInstance(): self {
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }
}