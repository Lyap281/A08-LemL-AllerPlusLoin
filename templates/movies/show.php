<!-- show film -->
<?php 

//Je vais chercher le numéro de l'id dans l'url de l'image
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
}

// je vais chercher toutes les infos du film correspondant à l'id présent dans l'url
$requetefiche = $db->prepare('SELECT * FROM movies WHERE movies.id='.$id.'');
$requetefiche->execute();
$datafilm = $requetefiche->fetch(PDO::FETCH_ASSOC);
?>

<!-- J'affiche l'affiche du film -->
<div class="row">
<div class="col-md-3">
<?php echo '<img class="rounded float-left " src=./uploads/'.$datafilm["image"].' alt= "Affiche du film"/>';?>
</div>
<!-- J'affiche les infos du film -->
<div class="card col-md-6 text-white bg-danger">
    <?php
    echo '<br /><h1 class="text-center">'.$datafilm["name"].'</h1><br />';
// Je change le format de la date pour l'afficher ensuite
    $replace = $db->prepare('SELECT movies.release_date, DATE_FORMAT(movies.release_date,\'%d %M %Y\') FROM movies WHERE movies.id ='.$id.'');
    $replace->execute();
    $date = $replace->fetch(PDO::FETCH_ASSOC);
    $newdate = $date['DATE_FORMAT(movies.release_date,\'%d %M %Y\')'];
    echo '<h5><em>Release date : '.$newdate.'</em></h5>';


    echo '<h5><em>Movie\'s duration : '.$datafilm["duration"].'</em></h5>';
    echo '<h5><em>Movie\'s director : '.$datafilm["director"].'</em></h5><br />';
    // J'affiche la valeur de la phase correspondant à l'id de la phase dans movies
    $phase = $db->prepare('SELECT phases.phase
                        FROM movies
                        JOIN phases ON phases.id = movies.id_phase
                        WHERE movies.id ='.$id.'');
    $phase->execute();
    $phaseN = $phase->fetch(PDO::FETCH_ASSOC);
    $valuephase = $phaseN["phase"];
    echo ('<h5><em>Phase '.$valuephase.'</em></h5><br /><br />');

    // J'affiche le casting
    $cast = $db->prepare('SELECT actors.last_name, actors.first_name, actors_movies.id_movies, actors_movies.id_actors, actors_movies.role 
    FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id 
    WHERE actors_movies.id_movies='.$id.'');
    $cast->execute();
    $casting = $cast->fetchAll(PDO::FETCH_ASSOC);
    echo '<h4 class="text-center"> Casting : </h4>';
    foreach($casting as $key => $value)
    {
        $actorln = $casting[$key]['last_name'];
        $actorfn = $casting[$key]['first_name'];
        $role = $casting[$key]['role'];
        
        echo '<strong><a class="text-dark" href="index.php?showactor&id='.$value['id_actors'].'">'.$actorfn.' '.$actorln.'</a></strong>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp  (Role : '.$role.')</a><br />';
    }
    
    // Boutons
    echo '<div class="d-flex justify-content-around"><a href="index.php?list"><button type="button" class="btn btn-warning font-weight-bold my-4 btn-lg">Back to the list</button></a>
    <a href="index.php?edit&id='.$id.'"><button type="button" class="btn btn-secondary font-weight-bold my-4 btn-lg">Edit the movie</button></a>
    <a href="#"><button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-dark font-weight-bold my-4 btn-lg">Delete the movie</button></a>';
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

                <div class="modal-body text-dark">Are you sure you want to delete the movie ?</div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <?php echo '<a href="index.php?delete&id='.$id.'"><button type="button" class="btn btn-primary">I\'m sure !</button></a>';?>
                </div>
            </div>
        </div>
    </div>

    


