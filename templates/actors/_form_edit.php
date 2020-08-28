<!-- form edit actors -->
<?php 
    include_once './settings/db.php';
// Je récupère l'id du film dans l'url s'il est présent et je l'enregistre dans $id
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
    }
?>


<form name="editactor" action="index.php" method="POST" enctype="multipart/form-data">  
    <div class="card col-md-10 my-1"><br />

        <h2 class="d-flex justify-content-center">Modify the actor informations</h2>

        <!-- La référence du film en hidden me permet ici d'envoyer l'id du film récupéré dans l'url via le formulaire 
        afin de pouvoir identifier le film dans mon WHERE pour modifier le bon film -->
        <div class="form-group col-sm-2">
            <label hidden for="ref">Référence de l'acteur</label>
            <input type="int" name="ref" id="ref" 
            value="
            <?php 
            $idactor = $db->query('SELECT actors.id FROM actors WHERE actors.id='.$id.'');
            $idactor->execute();
            $idactorN = $idactor->fetch(PDO::FETCH_ASSOC);
            $valueidactorN = $idactorN["id"];
            echo $valueidactorN;
            ?>" hidden required class="form-control">
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" id="last_name" 
            value="<?php $title = $db->query('SELECT actors.last_name FROM actors WHERE actors.id='.$id.'');
                $title->execute();
                $titleN = $title->fetch(PDO::FETCH_ASSOC);
                $valuetitleN = $titleN["last_name"];
                echo $valuetitleN;?>" 
            required class="form-control">
        </div>

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?php $director = $db->query('SELECT actors.first_name FROM actors WHERE actors.id='.$id.'');
                $director->execute();
                $directorN = $director->fetch(PDO::FETCH_ASSOC);
                $valuedirectorN = $directorN["first_name"];
                echo $valuedirectorN;?>" required class="form-control">
        </div>

        <div class="form-group">
                <label for="role">Role </label>
                <input type="text" name="role" value="<?php $role = $db->query('SELECT actors_movies.role FROM actors_movies WHERE actors_movies.id_actors='.$id.'');
                $role->execute();
                $roleN = $role->fetch(PDO::FETCH_ASSOC);
                $valueroleN = $roleN["role"];
                echo $valueroleN; ?>"required class="form-control">
            </div>

        
            <div class="form-group mx-auto">
                <label for="dob">Date of birth </label>&nbsp;&nbsp;
                <div><input type="date" name="dob" value="<?php $date = $db->query('SELECT actors.dob FROM actors WHERE actors.id='.$id.'');
                $date->execute();
                $dateN = $date->fetch(PDO::FETCH_ASSOC);
                $valuedateN = $dateN["dob"];
                echo $valuedateN;?>"></div>
            </div><br />

            <?php 
            // J'affiche les films où l'acteur à joué
            $filmo = $db->prepare('SELECT movies.name, actors_movies.id_movies, actors_movies.id_actors
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id 
            WHERE actors_movies.id_actors='.$id.'');
            $filmo->execute();
            $filmography = $filmo->fetchAll(PDO::FETCH_ASSOC);
            echo '<h5> Filmography : </h5><ul>';
            foreach($filmography as $key => $value)
            {
                $title = $filmography[$key]['name'];
                
                echo '<li><a class="text-dark" href="index.php?show&id='.$value['id_movies'].'">'.$title.'</a></li><br />';
            }
            '</ul>';
            // J'affiche la liste des films ajoutables
            $filmo2 = $db->prepare('SELECT movies.name, actors.id as iddelacteur, movies.id as iddumovie
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id
            GROUP BY movies.id');
            $filmo2->execute();
            $filmography2 = $filmo2->fetchAll(PDO::FETCH_ASSOC);

            // var_dump($filmography2);

            $filmsdelacteur = $db->prepare('SELECT movies.id 
            FROM actors_movies JOIN actors ON actors_movies.id_actors = actors.id JOIN movies ON actors_movies.id_movies = movies.id
            WHERE actors.id = '.$id.' GROUP BY movies.id');
            $filmsdelacteur->execute();
            $tableaudesfilmsdelacteur = $filmsdelacteur->fetchAll(PDO::FETCH_ASSOC);

            echo '<h5>Which other actor played in this movie ?</h5><br />';

            foreach($tableaudesfilmsdelacteur as $value)
            {
                $selectfilmsdelacteur[]= $value['id'];
            }

            // var_dump($selectfilmsdelacteur);

            // $sql = $db->prepare('SELECT movies.id FROM movies');
            // $sql->execute();
            // $fetch = $sql->fetchAll(PDO::FETCH_ASSOC);
            // foreach($fetch as $value)
            // {
            //     $allfilms[] = $value['id'];
            // }

            foreach($filmography2 as $tableaufilmo2)
            {
                $moviename = $tableaufilmo2['name'];

                $checked = "";
                if(in_array($tableaufilmo2['iddumovie'], $selectfilmsdelacteur))
                {
                    $checked = "hidden";
                }

                echo '<div class="form-group form-check-inline">
                    <input type="checkbox" class="form-check-input" name="idmovie[]" value="'.$tableaufilmo2["iddumovie"].'" id="'.$tableaufilmo2["iddumovie"].'"'.$checked.'>
                    <label class="form-check-label" for="'.$tableaufilmo2["iddumovie"].'"'.$checked.'>'.$moviename.'</label>
                </div>';
            }
        ?>

        <div class="card col-11 mx-auto my-1 ">
                <div class="p-2">
                    <?php 
                        $image = $db->prepare('SELECT actors.image FROM actors WHERE actors.id='.$id.'');
                        $image->execute();
                        $imageactor = $image->fetch(PDO::FETCH_ASSOC);
                        $valueimageactor = $imageactor["image"];
                    ?>
                </div>

                <div class="form-group">
                    <label for="image">Change the film poster</label>
                    <input type="file" class="form-control-file" id="image" name="image" value="image"><br />
                    <?php echo "<strong>Current film poster : </strong>".$valueimageactor.""; ?>
                </div>
        </div><br />  
    </div>
    <div class="d-flex justify-content-center">
            <a href="index.php"><button name="editactor" type="submit" class="btn btn-primary my-2 btn-lg">Save changes</button></a>
    </div><br />
</form>