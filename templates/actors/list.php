<!-- list actors -->
<?php 

include_once './settings/db.php'; 

// Je prends toutes les données de la bdd et je les mets dans le tableau $data
$requeteimg = $db->prepare('SELECT * FROM actors ORDER BY actors.last_name ASC');
$requeteimg->execute();
$data = $requeteimg->fetchAll(PDO::FETCH_ASSOC);


foreach($data as $key => $value)
{
    // $image_name transforme le tableau $data en chaine de caractère pour pouvoir afficher la ligne souhaitée
    $image_actor = $data[$key]['image'];
    // j'affiche les images cliquables de chaque film et $value["id"] permet de mettre le numéro de l'id correspondant au film dans l'url
    echo '<figure class="figure">'.
    '<a href="index.php?showactor&id='.$value["id"].'"><img class="figure-img img-fluid rounded mx-2" src="uploads/'.$image_actor.'" alt= "Affiche de films"></a>'.'
        <figcaption class="figure-caption"><strong><h5>&nbsp&nbsp'.$value["first_name"].' '.$value['last_name'].'</h5></strong></figcaption>
    </figure>';
    
}
    


?>