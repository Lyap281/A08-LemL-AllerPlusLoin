<!-- form new films -->
<?php 

    include_once './settings/db.php';
    // Je récupère l'id du film dans l'url s'il est présent et je l'enregistre dans $id
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
    }
     ?>

<form name="new" action="index.php" method="POST" enctype="multipart/form-data">  
    <div class="row">  
        <div class="card col-11 my-1"><br />

            <h2 class="d-flex justify-content-center">Add a new movie</h2>

            <div class="form-group">
                <label for="name">Title</label>
                <input type="text" name="name" id="name" placeholder="Movie's title" required class="form-control">
            </div>

            <div class="form-group">
                <label for="director">Director</label>
                <input type="text" name="director" id="director" placeholder="Movie's director" required class="form-control">
            </div>

            <div class="row">
                <div class="form-group mx-auto">
                    <label for="release_date">Release date </label>&nbsp;&nbsp;
                    <div><input type="date" name="release_date"></div>
                </div>

                <div class="form-group mx-auto">
                    <label for="duration">Duration </label>&nbsp;&nbsp;
                    <div><input type="time" name="duration"></div>
                </div>

                <div class="radio mx-auto">
                    <br />
                    <label><input type="radio" name="id_phase" value="1"> Phase I </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value="2"> Phase II </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value="3"> Phase III </label>&nbsp;&nbsp;
                </div>   
            </div>

            <div class="col-12 mx-auto"><br />
            <?php
            // J'affiche la liste de tous les acteurs
            $cast = $db->prepare('SELECT actors.last_name, actors.first_name, actors.id 
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id
            GROUP BY actors.last_name');
            $cast->execute();
            $casting = $cast->fetchAll(PDO::FETCH_ASSOC);
            echo '<h5>List of actors in the movie</h5><br />';
            foreach($casting as $key => $value)
            {
                $actorln = $casting[$key]['last_name'];
                $actorfn = $casting[$key]['first_name'];
                
                echo '<div class="form-group form-check-inline">
                    <input type="checkbox" class="form-check-input" name="idactor[]" value="'.$value["id"].'" id="'.$value["id"].'">
                    <label class="form-check-label" for="'.$value["id"].'">'.$actorfn.' '.$actorln.'</label>
                </div>';
            }
            ?>
        </div>

            <div class="card col-11 mx-auto my-3">
                <div class="form-group">
                    <label for="image">Attach film poster</label>
                    <input type="file" class="form-control-file" id="image" name="image" value="image">
                </div>
            </div><br />

            <div class="d-flex justify-content-center">
                <a href="index.php"><button name="new" type="submit" class="btn btn-primary my-2 btn-lg">Save the film</button></a>
            </div><br />   
    </div>
</form>






