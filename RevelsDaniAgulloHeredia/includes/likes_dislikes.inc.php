<?php
    $select_like = $conection->prepare('SELECT userid FROM likes WHERE userid=:iduser and revelid=:idrevel;');
    $select_like->bindParam(':idrevel', $_GET['like']);
    $select_like->bindParam(':iduser', $_SESSION['user']);
    $select_like->execute();

    $select_dislike = $conection->prepare('SELECT userid FROM dislikes WHERE userid=:iduser and revelid=:idrevel;');
    $select_dislike->bindParam(':idrevel', $_GET['dislike']);
    $select_dislike->bindParam(':iduser', $_SESSION['user']);
    $select_dislike->execute();


    if(isset($_GET['like'])){
        if(count($select_like->fetchAll())===0){  

            $deletedisLike = $conection->prepare('DELETE FROM dislikes where userid =:iduser and revelid=:idrevel ;');
            $deletedisLike->bindParam(':idrevel', $_GET['like']);
            $deletedisLike->bindParam(':iduser', $_SESSION['user']);
            $deletedisLike->execute();

            $add_like = $conection->prepare('INSERT INTO likes (revelid, userid) VALUES (:idrevel,:iduser);');
            $add_like->bindParam(':idrevel', $_GET['like']);
            $add_like->bindParam(':iduser', $_SESSION['user']);

            if (isset($_GET['like'])) {
                $add_like->execute();
            }                                           
        }else{
            $deleteLike = $conection->prepare('DELETE FROM likes where userid =:iduser and revelid=:idrevel ;');
            $deleteLike->bindParam(':idrevel', $_GET['like']);
            $deleteLike->bindParam(':iduser', $_SESSION['user']);
            $deleteLike->execute();                        
        }
    }


    if(isset($_GET['dislike'])){
        if(count($select_dislike->fetchAll())===0){   
            $deleteLike = $conection->prepare('DELETE FROM likes where userid =:iduser and revelid=:idrevel ;');
            $deleteLike->bindParam(':idrevel', $_GET['dislike']);
            $deleteLike->bindParam(':iduser', $_SESSION['user']);
            $deleteLike->execute();

            $add_dislike = $conection->prepare('INSERT INTO dislikes (revelid, userid) VALUES (:idrevel,:iduser);');
            $add_dislike->bindParam(':idrevel', $_GET['dislike']);
            $add_dislike->bindParam(':iduser', $_SESSION['user']);

            if (isset($_GET['dislike'])) {
                $add_dislike->execute();
            }                                           
        }else{
            $deletedisLike = $conection->prepare('DELETE FROM dislikes where userid =:iduser and revelid=:idrevel ;');
            $deletedisLike->bindParam(':idrevel', $_GET['dislike']);
            $deletedisLike->bindParam(':iduser', $_SESSION['user']);
            $deletedisLike->execute();               
        }
    }
?>