<!-- form edit movies -->
<?php 
    include_once './settings/db.php';
// Je récupère l'id du film dans l'url s'il est présent et je l'enregistre dans $id
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
    }
?>


<form name="edit" action="index.php" method="POST" enctype="multipart/form-data">  
    <div class="card col-md-10 my-1"><br />

        <h2 class="d-flex justify-content-center">Modify the movie informations</h2>

        <!-- La référence du film en hidden me permet ici d'envoyer l'id du film récupéré dans l'url via le formulaire 
        afin de pouvoir identifier le film dans mon WHERE pour modifier le bon film -->
        <div class="form-group col-sm-2">
            <label hidden for="ref">Référence du film</label>
            <input type="int" name="ref" id="ref" 
            value="
            <?php 
            $idfilm = $db->query('SELECT movies.id FROM movies WHERE movies.id='.$id.'');
            $idfilm->execute();
            $idfilmN = $idfilm->fetch(PDO::FETCH_ASSOC);
            $valueidfilmN = $idfilmN["id"];
            echo $valueidfilmN;
            ?>" hidden required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="name">Title</label>
            <input type="text" name="name" id="name" 
            value="<?php $title = $db->query('SELECT movies.name FROM movies WHERE movies.id='.$id.'');
                $title->execute();
                $titleN = $title->fetch(PDO::FETCH_ASSOC);
                $valuetitleN = $titleN["name"];
                echo $valuetitleN;?>" 
            required class="form-control">
        </div>

        <div class="form-group">
            <label for="director">Director</label>
            <input type="text" name="director" id="director" value="<?php $director = $db->query('SELECT movies.director FROM movies WHERE movies.id='.$id.'');
                $director->execute();
                $directorN = $director->fetch(PDO::FETCH_ASSOC);
                $valuedirectorN = $directorN["director"];
                echo $valuedirectorN;?>" required class="form-control">
        </div>

        <div class="row">
            <div class="form-group mx-auto">
                <label for="release_date">Release date </label>&nbsp;&nbsp;
                <div><input type="date" name="release_date" value="<?php $date = $db->query('SELECT movies.release_date FROM movies WHERE movies.id='.$id.'');
                $date->execute();
                $dateN = $date->fetch(PDO::FETCH_ASSOC);
                $valuedateN = $dateN["release_date"];
                echo $valuedateN;?>"></div>
            </div>

            <div class="form-group mx-auto">
                <label for="duration">Duration </label>&nbsp;&nbsp;
                <div><input type="time" name="duration" value="<?php $duration = $db->query('SELECT movies.duration FROM movies WHERE movies.id='.$id.'');
                $duration->execute();
                $durationN = $duration->fetch(PDO::FETCH_ASSOC);
                $valuedurationN = $durationN["duration"];
                echo $valuedurationN;?>"></div>
            </div>

            <div class="radio mx-auto">
                <br />
                <!-- Je récupère l'id de la phase dans movies -->
                <?php $id_phase = $db->query('SELECT movies.id_phase FROM movies WHERE movies.id='.$id.'');
                $id_phase->execute();
                $phaseN = $id_phase->fetch(PDO::FETCH_ASSOC);
                $valuephaseN = $phaseN["id_phase"];

                // Je présélectionne la phase grâce à l'id présent dans movies
                if($valuephaseN==1)
                {
                    ?><label><input type="radio" name="id_phase" value='1' checked> Phase I </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='2'> Phase II </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='3'> Phase III </label>&nbsp;&nbsp;<?php
                }
                elseif($valuephaseN==2)
                {
                    ?><label><input type="radio" name="id_phase" value='1'> Phase I </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='2' checked> Phase II </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='3'> Phase III </label>&nbsp;&nbsp;<?php
                }
                elseif($valuephaseN==3)
                {
                    ?><label><input type="radio" name="id_phase" value='1'> Phase I </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='2'> Phase II </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='3' checked> Phase III </label>&nbsp;&nbsp;<?php
                }
                else
                {
                    ?><label><input type="radio" name="id_phase" value='1'> Phase I </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='2'> Phase II </label>&nbsp;&nbsp;
                    <label><input type="radio" name="id_phase" value='3'> Phase III </label>&nbsp;&nbsp;<?php
                }
                ?>
            </div>   
        </div>

        <?php 
            // J'affiche les acteurs associés au film
            $cast = $db->prepare('SELECT actors.last_name, actors.first_name, actors_movies.id_movies, actors_movies.id_actors
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id 
            WHERE actors_movies.id_movies='.$id.'');
            $cast->execute();
            $casting = $cast->fetchAll(PDO::FETCH_ASSOC);
            echo '<h5> Actuals actors : </h5><ul>';
            foreach($casting as $key => $value)
            {
                $actorln = $casting[$key]['last_name'];
                $actorfn = $casting[$key]['first_name'];
                
                echo '<li><a class="text-dark" href="index.php?showactor&id='.$value['id_actors'].'">'.$actorfn.' '.$actorln.'</a></li><br />';
            }
            '</ul>';
            // J'affiche la liste des acteurs ajoutables
            $cast2 = $db->prepare('SELECT actors.last_name, actors.first_name, actors.id as iddelacteur, movies.id as iddumovie
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id
            GROUP BY actors.last_name');
            $cast2->execute();
            $casting2 = $cast2->fetchAll(PDO::FETCH_ASSOC);


            $acteurdufilm = $db->prepare('SELECT actors.id 
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id
            WHERE movies.id = '.$id.' GROUP BY actors.last_name');
            $acteurdufilm->execute();
            $tableauacteurdufilm = $acteurdufilm->fetchAll(PDO::FETCH_ASSOC);

            echo '<h5>Which other actor played in this movie ?</h5><br />';

            foreach($tableauacteurdufilm as $value)
            {
                $actorsdufilm[]= $value['id'];
            }

            // $sql = $db->prepare('SELECT actors.id FROM actors');
            // $sql->execute();
            // $fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
            // foreach($fetch as $value)
            // {
            //     $actorstous[] = $value['id'];
            // }

            foreach($casting2 as $tableaucasting2)
            {
                $actorln2 = $tableaucasting2['last_name'];
                $actorfn2 = $tableaucasting2['first_name'];

                $checked = "";
                if(in_array($tableaucasting2['iddelacteur'], $actorsdufilm))
                {
                    $checked = "hidden";
                }

                echo '<div class="form-group form-check-inline">
                    <input type="checkbox" class="form-check-input" name="idactor[]" value="'.$tableaucasting2["iddelacteur"].'" id="'.$tableaucasting2["iddelacteur"].'"'.$checked.'>
                    <label class="form-check-label" for="'.$tableaucasting2["iddelacteur"].'"'.$checked.'>'.$actorfn2.' '.$actorln2.'</label>
                </div>';
            }
        ?>

        <div class="card col-11 mx-auto my-1 ">
                <div class="p-2">
                    <?php 
                        $image = $db->prepare('SELECT movies.image FROM movies WHERE movies.id='.$id.'');
                        $image->execute();
                        $imagefilm = $image->fetch(PDO::FETCH_ASSOC);
                        $valueimagefilm = $imagefilm["image"];
                    ?>
                </div>


                <div class="form-group">
                    <label for="image">Change the film poster</label>
                    <input type="file" class="form-control-file" id="image" name="image" value="image"><br />
                    <?php echo "<strong>Current film poster : </strong>".$valueimagefilm.""; ?>
                </div>
        </div><br />
    

        <div class="d-flex justify-content-center">
            <a href="index.php"><button name="edit" type="submit" class="btn btn-primary">Save changes</button></a>
        </div><br />
    </div>
</form>