<!-- show actor -->
<?php 

//Je vais chercher le numéro de l'id dans l'url de l'image
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
}

// je vais chercher toutes les infos du film correspondant à l'id présent dans l'url
$requetefiche = $db->prepare('SELECT * FROM actors WHERE actors.id='.$id.'');
$requetefiche->execute();
$dataactor = $requetefiche->fetch(PDO::FETCH_ASSOC);
?>

<!-- J'affiche la photo de l'acteur -->
<div class="row">
<div class="col-md-3">
<?php echo '<img class="rounded float-left " src=./uploads/'.$dataactor["image"].' alt= "Affiche du film"/>';?>
</div>
<!-- J'affiche les infos de l'acteur -->
<div class="card col-md-6 text-white bg-danger">
    <?php
    echo '<br /><h1 class="text-center">'.$dataactor["first_name"].' '.$dataactor["last_name"].'</h1><br />';

    // Je change le format de la date pour l'afficher ensuite
    $replace = $db->prepare('SELECT actors.dob, DATE_FORMAT(actors.dob,\'%d %M %Y\') FROM actors WHERE actors.id ='.$id.'');
    $replace->execute();
    $date = $replace->fetch(PDO::FETCH_ASSOC);
    $newdate = $date['DATE_FORMAT(actors.dob,\'%d %M %Y\')'];
    echo '<h5><em>Date of birth : '.$newdate.'</em></h5><br />';

    // J'affiche la filmographie
    $filmo = $db->prepare('SELECT movies.name, actors_movies.id_movies, actors_movies.id_actors, actors_movies.role 
    FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id 
    WHERE actors_movies.id_actors='.$id.'');
    $filmo->execute();
    $filmoN = $filmo->fetchAll(PDO::FETCH_ASSOC);
    echo '<h4 class="text-center"> Filmography : </h4>';
    foreach($filmoN as $key => $value)
    {
        $filmname = $filmoN[$key]['name'];
        $role = $filmoN[$key]['role'];
        
        echo '<a class="text-dark" href="index.php?show&id='.$value['id_movies'].'"><strong>'.$filmname.'</a></strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  (Role : '.$role.')<br />';
    }
    
    
    // Boutons
    echo '<div class="d-flex justify-content-around"><a href="index.php?listactors"><button type="button" class="btn btn-warning font-weight-bold my-4 btn-lg">Back to the list</button></a>
    <a href="index.php?editactor&id='.$id.'"><button type="button" class="btn btn-secondary font-weight-bold my-4 btn-lg">Edit the actor</button></a>
    <a href="#"><button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-dark font-weight-bold my-4 btn-lg">Delete the actor</button></a>';
    ?>

    <!-- POP-UP -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">Alert !</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-dark">Are you sure you want to delete this actor ?</div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <?php echo '<a href="index.php?deleteactor&id='.$id.'"><button type="button" class="btn btn-primary">I\'m sure !</button></a>';?>
                </div>
            </div>
        </div>
    </div>