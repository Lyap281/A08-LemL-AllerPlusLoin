<?php

// Connexion à la BDD
    //Le PDO représente l'objet qui lie la BDD et PHP
    $host = "localhost:3308";
    $dbname = "a08";
    $login = "A08";
    $mdp = "mdp";
        //Essaye ça, si ça ne marche pas alors tu attrapes l'erreur, tu arrêtes tout et tu affiches l'erreur
            try
            {
                $db = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8',$login,$mdp);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e)
            {
                die('Erreur : ' . $e->getMessage());
            }
?>