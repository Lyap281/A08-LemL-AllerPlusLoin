<!-- form new actors -->
<?php 
include_once './settings/db.php';
// Je récupère l'id du film dans l'url s'il est présent et je l'enregistre dans $id
if(isset($_GET["id"]))
{
    $id = $_GET["id"];
}
?>

<form name="newactor" action="./index.php" method="POST" enctype="multipart/form-data">  
    <div class="card col-md-10 my-1"><br />

        <h2 class="d-flex justify-content-center">Add a new actor</h2>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" placeholder="Actor's Last Name" required class="form-control">
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" placeholder="Actor's First Name" required class="form-control">
        </div>

        <div class="row">
            <div class="form-group mx-auto">
                <label for="dob">Date of birth </label>&nbsp;&nbsp;
                <div><input type="date" name="dob"></div>
            </div>
            <div class="form-group mx-auto">
                <label for="dob">Role </label>&nbsp;&nbsp;
                <div><input type="text" placeholder="Actor's role" name="role"></div>
            </div>
            
            <div class="col-12 mx-auto"><br />
            <?php
            // J'affiche la liste de tous les films
            $films = $db->prepare('SELECT movies.name, movies.id 
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id
            GROUP BY movies.name');
            $films->execute();
            $filmography = $films->fetchAll(PDO::FETCH_ASSOC);
            echo '<h5>List of actors in the movie</h5><br />';
            foreach($filmography as $key => $value)
            {
                $title = $filmography[$key]['name'];
                
                echo '<div class="form-group form-check-inline">
                    <input type="checkbox" class="form-check-input" name="idmovie[]" value="'.$value["id"].'" id="'.$value["id"].'">
                    <label class="form-check-label" for="'.$value["id"].'">'.$title.'</label>
                </div>';
            }
            ?>

        <div class="card col-11 mx-auto my-1">
            <div class="form-group">
                <label for="image">Actor's photo</label>
                <input type="file" class="form-control-file" id="image" name="image" value="image">
            </div>
        </div><br />
    

        <div class="mx-auto my-3">
            <a href="index.php"><button name="newactor" type="submit" class="btn btn-primary">Save the actor</button></a>
        </div><br />
    </div>

</form>
