<?php 
include_once './settings/db.php'; ?>

<!DOCTYPE html>
<html lang="en">

    <?php include_once './templates/head.html'; ?>

    <body>
        
        <?php include_once './templates/header.html'; ?>

        <div class="row">
        
            <div class="col-3 ">
                <?php 
                include_once './templates/nav.html';
                include_once './templates/search.php';
                ?></div>
        
            <section class="col-9">
            <?php
            // Conditions avec $_GET pour les films
                if(isset($_GET["add"]))
                    {
                        include_once './templates/movies/_form_new.php';
                    }
                    
                elseif(isset($_GET["edit"]))
                    {
                        include_once './templates/movies/_form_edit.php';
                    }
                    
                elseif(isset($_GET["list"]))
                    {
                        include_once './templates/movies/list.php';
                        echo "<br /><br /><a href='index.php?add'><button type='button' class='btn btn-warning btn-lg shadow-lg p-3 mb-5 font-weight-bold'>Add a new MARVEL'S movie</button></a>";
                    }
                elseif(isset($_GET["show"]))
                    {
                        include_once './templates/movies/show.php';
                    }
                elseif(isset($_GET['delete']))
                {                     
                    if(isset($_GET["id"]))
                    {
                        $id = $_GET["id"];
                        $delete = $db->prepare("DELETE FROM movies WHERE movies.id =$id");
                        $delete->execute();
                        echo '<div class="alert alert-success text-center col-11" role="alert">The movie was deleted.</div>';
                    }
                }
                // Conditions avec $_GET pour les acteurs
                elseif(isset($_GET["addactor"]))
                    {
                        include_once './templates/actors/_form_new.php';
                    }
                    
                elseif(isset($_GET["editactor"]))
                    {
                        include_once './templates/actors/_form_edit.php';
                    }
                    
                elseif(isset($_GET["listactors"]))
                    {
                        include_once './templates/actors/list.php';
                        echo "<br /><br /><a href='index.php?addactor'><button type='button' class='btn btn-warning btn-lg shadow-lg p-3 mb-5 font-weight-bold'>Add a new actor</button></a>";
                    }
                elseif(isset($_GET["showactor"]))
                    {
                        include_once './templates/actors/show.php';
                    }
                elseif(isset($_GET['deleteactor']))
                {                     
                    if(isset($_GET["id"]))
                    {
                        $id = $_GET["id"];
                        $delete = $db->prepare("DELETE FROM actors WHERE actors.id =$id");
                        $delete->execute();
                        echo '<div class="alert alert-success text-center col-11" role="alert">The actor was deleted.</div>';
                    }
                }
                                
                // Traitement de formulaire d'ajout d'un film
                elseif(isset($_POST['new']))
                {
                    $extensions = array('.jpg');
                    $extension = strrchr($_FILES['image']['name'], '.');
                    $error = $_FILES['image']['error'];
    
                        // Si le fichier dépasse 2mo alors...
                        if($_FILES['image']['size'] > 2000000)
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">Size over 2mo</div>';
                        }
                        // S'il s'agit de l'erreur 4 alors...
                        elseif($_FILES['image']['error'] == 4)
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">No files have been uploaded</div>';
                        }
                        // Si l'extention envoyée n'est pas dans le tableau alors...
                        elseif(!in_array($extension, $extensions))
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">Format not supported : ' . $extension .'</div>';
                        }
                        // Sinon S'il y a une autre erreur alors on affiche le code de l'erreur
                        elseif($_FILES['image']['error'] != 0)
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">Error ' . $error .'</div>';
                        }
                        // S'il n'y a aucune erreur alors...
                        else
                        {
                            echo '<div class="alert alert-success text-center col-11" role="alert">Image saved</div>';
                            echo '<div class="alert alert-success text-center col-11" role="alert">The data has been saved.</div>';
                            move_uploaded_file($_FILES['image']['tmp_name'], './uploads/' .$_FILES['image']['name']);
    
                            $insert = $db->prepare("INSERT INTO movies(`name`,`release_date`,`duration`,`director`,`id_phase`,`image`) VALUES (?,?,?,?,?,?)");
                            $insert->execute(array($_POST['name'],
                            $_POST['release_date'],
                            $_POST['duration'],
                            $_POST['director'],
                            $_POST['id_phase'],
                            $_FILES['image']['name']));

                            $newmovie = $db->lastInsertId();
                            foreach($_POST["idactor"] as $value)
                            {
                                $insertcheck = $db->prepare("INSERT INTO actors_movies(`id_actors`,`id_movies`) VALUES (?,?)");
                                $insertcheck->execute(array($value,
                                $newmovie));
                            }
                            
                        }                        
                }

                // Traitement de formulaire d'update d'un film
                elseif(isset($_POST['edit']))
                {
                    if(isset($_POST['name']) && !empty($_POST['name']))
                    {
                        if(isset($_POST['release_date']) && !empty($_POST['release_date']))
                        {
                            if(isset($_POST['duration']) && !empty($_POST['duration']))
                            {
                                if(isset($_POST['director']) && !empty($_POST['director']))
                                {
                                    if(isset($_POST['id_phase']) && !empty($_POST['id_phase']))
                                    {
                                        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
                                        {
                                            $extensions = array('.jpg');
                                            $extension = strrchr($_FILES['image']['name'], '.');
                                            $error = $_FILES['image']['error'];
                                                // Si le fichier dépasse 2mo alors...
                                                if($_FILES['image']['size'] > 2000000)
                                                {
                                                    echo '<div class="alert alert-danger text-center col-11" role="alert">Size over 2mo</div>';
                                                }
                                                // S'il s'agit de l'erreur 4 alors...
                                                elseif($_FILES['image']['error'] == 4)
                                                {
                                                    echo '<div class="alert alert-danger text-center col-11" role="alert">No files have been uploaded</div>';
                                                }
                                                // Si l'extention envoyée n'est pas dans le tableau alors...
                                                elseif(!in_array($extension, $extensions))
                                                {
                                                    echo '<div class="alert alert-danger text-center col-11" role="alert">Format not supported : ' . $extension .'</div>';
                                                }
                                                // Sinon S'il y a une autre erreur alors on affiche le code de l'erreur
                                                elseif($_FILES['image']['error'] != 0)
                                                {
                                                    echo '<div class="alert alert-danger text-center col-11" role="alert">Error ' . $error .'</div>';
                                                }
                                                // S'il n'y a aucune erreur alors...
                                                else
                                                { 
                                                    echo '<div class="alert alert-success text-center col-11" role="alert">Image saved</div>';
                                                    echo '<div class="alert alert-success text-center col-11" role="alert">The data has been saved.</div>';
                                                    move_uploaded_file($_FILES['image']['tmp_name'], './uploads/' .$_FILES['image']['name']);

                                                    $FilmAModifierID = htmlspecialchars($_POST["ref"]);
                                                    $title = htmlspecialchars($_POST['name']);
                                                    $date = htmlspecialchars($_POST['release_date']);
                                                    $duration = htmlspecialchars($_POST['duration']);
                                                    $director = htmlspecialchars($_POST['director']);
                                                    $idphase = htmlspecialchars($_POST['id_phase']);
                                                    $files = htmlspecialchars($_FILES['image']['name']);
                                                    
                                                    $maj = $db->prepare("UPDATE movies SET movies.name='".$title."',movies.release_date='".$date."',movies.duration='".$duration."',movies.director='".$director."',movies.id_phase=$idphase,movies.image='".$files."' WHERE movies.id=$FilmAModifierID");
                                                    $maj->execute();

                                                    $idactor = $_POST['idactor'];
                                                    $ajoutacteuraufilm = $db->prepare("INSERT INTO actors_movies (id_actors, id_movies) VALUES (?,?)");
                                                    
                                                    foreach($idactor as $value)
                                                    {   
                                                        $ajoutacteuraufilm->execute(array($value, $FilmAModifierID));
                                                    }

                                                    
                                                }
                                                                   
                                        }
                                        
                                    }
                                }
                            }
                        }
                    }
                }

                // Traitement de la barre de recherche
                elseif(isset($_GET['search']) && !empty($_GET['search']))
                {
                    $search = htmlspecialchars($_GET['search']);
                    ucwords($search);
                    $movie = $db->prepare('SELECT movies.name, actors_movies.id_actors, actors_movies.id_movies, movies.image as movieimg, actors.image as actorimg 
                    FROM `actors_movies`
                    JOIN `actors` ON `actors_movies`.`id_actors` = `actors`.`id`
                    JOIN `movies` ON `actors_movies`.`id_movies` = `movies`.`id`
                    WHERE 
                    (`movies`.`name` LIKE "%'.$search.'%") OR
                    (`actors`.`last_name` LIKE "%'.$search.'%") OR
                    (`actors`.`first_name` LIKE "%'.$search.'%")
                    GROUP BY movies.name ORDER BY movies.release_date ASC');
                    $movie->execute();

                    $actor = $db->prepare('SELECT actors.last_name, actors.first_name, actors_movies.id_actors, actors_movies.id_movies, movies.image as movieimg, actors.image as actorimg 
                    FROM `actors_movies`
                    JOIN `actors` ON `actors_movies`.`id_actors` = `actors`.`id`
                    JOIN `movies` ON `actors_movies`.`id_movies` = `movies`.`id`
                    WHERE 
                    (`movies`.`name` LIKE "%'.$search.'%") OR
                    (`actors`.`last_name` LIKE "%'.$search.'%") OR
                    (`actors`.`first_name` LIKE "%'.$search.'%")
                    GROUP BY actors.last_name ORDER BY movies.release_date ASC');
                    $actor->execute();

                    if($movie->rowCount() > 0) 
                    {
                        echo "<h4>Movie : </h4><br />";
                        while($m = $movie->fetch(PDO::FETCH_ASSOC)) 
                        {
                            echo '<figure class="figure">'.
                                 '<a href="index.php?show&id='.$m["id_movies"].'"><img class="figure-img img-fluid rounded mx-2" src="uploads/'.$m["movieimg"].'" alt= "photo"></a>'.'
                                  <figcaption class="figure-caption"><strong><h5>&nbsp&nbsp'.$m["name"].'</h5></strong></figcaption>
                                  </figure>';
                        }
                        echo "<br /><hr /><br />";
                        echo "<h4>Actor : </h4><br />";
                        while($a = $actor->fetch(PDO::FETCH_ASSOC)) 
                        {
                            echo '<figure class="figure">'.
                                 '<a href="index.php?showactor&id='.$a["id_actors"].'"><img class="figure-img img-fluid rounded mx-2" src="uploads/'.$a["actorimg"].'" alt= "photo"></a>'.'
                                  <figcaption class="figure-caption"><strong><h5>&nbsp&nbsp'.$a["first_name"].' '.$a['last_name'].'</h5></strong></figcaption>
                                  </figure>';
                        }
                    }
                    else 
                    {
                        echo '<div class="alert alert-danger text-center col-11" role="alert">No result for : '. $search .' ...</div>';
                    }
                }


                // Traitement de formulaire d'ajout d'un acteur
                elseif(isset($_POST['newactor']))
                {
                    $extensions = array('.jpg');
                    $extension = strrchr($_FILES['image']['name'], '.');
                    $error = $_FILES['image']['error'];
    
                        // Si le fichier dépasse 2mo alors...
                        if($_FILES['image']['size'] > 2000000)
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">Size over 2mo</div>';
                        }
                        // S'il s'agit de l'erreur 4 alors...
                        elseif($_FILES['image']['error'] == 4)
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">No files have been uploaded</div>';
                        }
                        // Si l'extention envoyée n'est pas dans le tableau alors...
                        elseif(!in_array($extension, $extensions))
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">Format not supported : ' . $extension .'</div>';
                        }
                        // Sinon S'il y a une autre erreur alors on affiche le code de l'erreur
                        elseif($_FILES['image']['error'] != 0)
                        {
                            echo '<div class="alert alert-danger text-center col-11" role="alert">Error ' . $error .'</div>';
                        }
                        // S'il n'y a aucune erreur alors...
                        else
                        {
                            echo '<div class="alert alert-success text-center col-11" role="alert">Image saved</div>';
                            echo '<div class="alert alert-success text-center col-11" role="alert">The data has been saved.</div>';
                            move_uploaded_file($_FILES['image']['tmp_name'], './uploads/' .$_FILES['image']['name']);
    
                            $insert = $db->prepare("INSERT INTO actors(`last_name`,`first_name`,`dob`,`image`) VALUES (?,?,?,?)");
                            $insert->execute(array($_POST['last_name'],
                            $_POST['first_name'],
                            $_POST['dob'],
                            $_FILES['image']['name']));

                            $newactor = $db->lastInsertId();
                            foreach($_POST["idmovie"] as $value)
                            {
                                $insertcheck = $db->prepare("INSERT INTO actors_movies(`id_actors`,`id_movies`, `role`) VALUES (?,?,?)");
                                $insertcheck->execute(array($newactor,
                                $value,
                                $_POST['role']));
                            }
                        }                        
                }
                

                 // Traitement de formulaire d'update d'un acteur
                elseif(isset($_POST['editactor']))
                {
                    if(isset($_POST['last_name']) && !empty($_POST['last_name']))
                    {
                        if(isset($_POST['first_name']) && !empty($_POST['first_name']))
                        {
                            if(isset($_POST['dob']) && !empty($_POST['dob']))
                            {
                                if(isset($_POST['role']) && !empty($_POST['role']))
                                {
                                    if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name']))
                                    {
                                        $extensions = array('.jpg');
                                        $extension = strrchr($_FILES['image']['name'], '.');
                                        $error = $_FILES['image']['error'];
                                            // Si le fichier dépasse 2mo alors...
                                            if($_FILES['image']['size'] > 2000000)
                                            {
                                                echo '<div class="alert alert-danger text-center col-11" role="alert">Size over 2mo</div>';
                                            }
                                            // S'il s'agit de l'erreur 4 alors...
                                            elseif($_FILES['image']['error'] == 4)
                                            {
                                                echo '<div class="alert alert-danger text-center col-11" role="alert">No files have been uploaded</div>';
                                            }
                                            // Si l'extention envoyée n'est pas dans le tableau alors...
                                            elseif(!in_array($extension, $extensions))
                                            {
                                                echo '<div class="alert alert-danger text-center col-11" role="alert">Format not supported : ' . $extension .'</div>';
                                            }
                                            // Sinon S'il y a une autre erreur alors on affiche le code de l'erreur
                                            elseif($_FILES['image']['error'] != 0)
                                            {
                                                echo '<div class="alert alert-danger text-center col-11" role="alert">Error ' . $error .'</div>';
                                            }
                                            // S'il n'y a aucune erreur alors...
                                            else
                                            { 
                                                echo '<div class="alert alert-success text-center col-11" role="alert">Image saved</div>';
                                                echo '<div class="alert alert-success text-center col-11" role="alert">The data has been saved.</div>';
                                                move_uploaded_file($_FILES['image']['tmp_name'], './uploads/' .$_FILES['image']['name']);

                                                $ActeurAModifierID = htmlspecialchars($_POST["ref"]);
                                                $ln = htmlspecialchars($_POST['last_name']);
                                                $fn = htmlspecialchars($_POST['first_name']);
                                                $dob = htmlspecialchars($_POST['dob']);
                                                $role = htmlspecialchars($_POST['role']);
                                                $files = htmlspecialchars($_FILES['image']['name']);
                                                
                                                $maj = $db->prepare("UPDATE actors SET actors.last_name='".$ln."',actors.first_name='".$fn."',actors.dob='".$dob."',actors.image='".$files."' WHERE actors.id=$ActeurAModifierID");
                                                $maj->execute();

                                                $majrolejointure = $db->prepare("UPDATE actors_movies SET actors_movies.role='".$role."' WHERE actors_movies.id_actors=$ActeurAModifierID");
                                                $majrolejointure->execute();

                                                $idmovie = $_POST['idmovie'];
                                                $ajoutfilmalacteur = $db->prepare("INSERT INTO actors_movies (id_actors, id_movies) VALUES (?,?)");
                                                
                                                foreach($idmovie as $value)
                                                {   
                                                    $ajoutfilmalacteur->execute(array($ActeurAModifierID, $value));
                                                }
                                            }
                                                            
                                    }
                                
                                }
                            }
                        }
                    }
                }
                else
                {
                    echo "<h1>Welcome in the MARVEL'S Universe !</h1><br />";
                }

                
            ?>
        
            </section>
        </div>
        <?php include_once './templates/footer.html'; ?>

    </body>

</html>
