<?php
namespace System;

// Vu qu'on travaille avec des namespaces on est maintenant obligé de redeclarer le namespace global pour des classes natives de PHP (PDO, DateTime, etc)
use PDO;

class DB
{
    const DB_HOST = 'mysql:host=localhost;';
    const DB_DATABASE = 'dbname=drawer;charset=utf8';
    const DB_USERNAME = 'partagimage';
    const DB_PASSWORD = 'prtg025';

    protected static $pdo = null;

    function __construct()
    {
        if (self::$pdo == null) {
            try {
                //  on se connecte à la BDD créée via PHPMyAdmin
                self::$pdo = new PDO(
                    self::DB_HOST.self::DB_DATABASE,
                    self::DB_USERNAME,
                    self::DB_PASSWORD,
                    [
                        // on active le mode d'exception pour afficher plus précisément les erreurs
                        // et le mode fetch assoc par défaut pour la récupération des données de la BDD
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
                // on force l'affichage en UTF8
                self::$pdo->exec('SET NAMES utf8');
            }
            catch (PDOException $e) {
                // en cas d'erreur on affiche un message d'erreur personnalisé avec l'erreur correspondante
                die('Erreur : ' .$e->getMessage());
            }
        }
    }

    /**
     * @return null|PDO
     */
    public static function getPdo()
    {
        return self::$pdo;
    }

    public function queryOne($sql, $values = [])
    {
        $query = self::$pdo->prepare($sql);
        $query->execute($values);
        return $query->fetch();
    }

    public function query($sql, $values = [])
    {
        $query = self::$pdo->prepare($sql);
        $query->execute($values);
        return $query->fetchAll();
    }

    public function execute($sql, $values = [])
    {
        $query = self::$pdo->prepare($sql);
        $query->execute($values);
        return $query;
    }
}
