<?php

    require_once "./../../../session/session.inc.php";

    $pdo->beginTransaction();

    if(isset($_POST["qid"])
       && $isLoggedIn) {

        if($_POST["qid"] != "") {
            
            $qid = $_POST["qid"];
            $uid = $_SESSION['id'];
        
            // check if quote exists
            $getQuote = $pdo->prepare("SELECT * FROM quotes WHERE id = ?");
            $getQuote->execute([$qid]);
            
            if($getQuote->rowCount() > 0){
                
                
                // get upvote sum
                $sumQuotesFavorites = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND deleted = '0'");
                $sumQuotesFavorites->execute([$qid]);
                $sum = $sumQuotesFavorites->rowCount();
                
                
                // check if faved
                $getQuoteFavorite = $pdo->prepare("SELECT * FROM quotes_favorites WHERE qid = ? AND uid = ?");
                $getQuoteFavorite->execute([$qid, $uid]);

                if($getQuoteFavorite->rowCount() > 0) {

                    // fave exists
                    $getQuoteFavoriteDeleted = $getQuoteFavorite->fetch();
                    $success_output = "0";
                    $setFavorite = "0";
                    
                    if($getQuoteFavoriteDeleted->deleted == "1") {

                        // fave quote
                        $setFavorite = '0';
                        $success_output = '1';

                    } else {

                        // unfave quote
                        $setFavorite = '1';
                        $success_output = '2';

                    }
                    
                    $quoteAction = $pdo->prepare("UPDATE quotes_favorites SET deleted = ? WHERE qid = ? AND uid = ?");
                    $quoteAction->execute([$setFavorite, $qid, $uid]);

                } else {

                    // add new fave
                    $quoteAction = $pdo->prepare("INSERT INTO quotes_favorites (qid, uid) VALUES (?,?)");
                    $quoteAction->execute([$qid, $uid]);
                    $success_output = '1';

                }
                
                // set base sum
                $newSum = $sum;
                
                // calculate new sum of upvotes
                if($success_output == "1") {
                    $newSum = $sum + 1;
                } else if($success_output == "2") {
                    $newSum = $sum - 1;
                }
                
                // update sum
                $updateQuotesFavorites = $pdo->prepare("UPDATE quotes SET upvotes = ? WHERE id = ?");
                $updateQuotesFavorites->execute([$newSum, $qid]);
                    
                    
                if($quoteAction && $updateQuotesFavorites) {

                    $pdo->commit();
                    exit($success_output);
                    
                } else {
                    
                    $pdo->rollback();
                    exit('0');
                    
                }
            
                
            } else { exit('0'); } // unknown error
        } else { exit('0'); } // unknown error
    } else { exit('0'); } // unknown error

?>