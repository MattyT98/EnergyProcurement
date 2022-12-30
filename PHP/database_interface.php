<?php
//Connect to the database
require("database_connection.php");
//Verify account session
function VerifyUserSession($PDO, $username){
    $RESULT = $PDO->query("SELECT `username` FROM `client_accounts` WHERE `username`='$username'");
    if (!$RESULT){
        require __DIR__.'/redirects/userss/redirect_login.php';
        exit;
    }
};
function VerifyStaffSession($PDO, $username){
    $RESULT = $PDO->query("SELECT `username` FROM `staff_accounts` WHERE `username`='$username'");
    if (!$RESULT){
        require __DIR__.'/redirects/staff/redirect_login.php';
        exit;
    }
};
//Verify user login
function VerifyUserLogin($PDO,$username,$password){

    $RESULT = $PDO->query("SELECT * FROM `client_accounts` WHERE `username`='$username'");

    if (!$RESULT){
        require __DIR__.'/redirects/users/redirect_login.php';
        exit;
    }

    $ROW = $RESULT->fetch(); //Get row from result(s)

    if (!$ROW){
        require __DIR__.'/redirects/users/redirect_login.php';
        exit;
    }

    $hashed = $ROW['password'];
    if (password_verify($password,$hashed))
    {
        $_SESSION['username'] = $ROW['username']; //User logged in and is saved for this session.
        require __DIR__.'/redirects/users/redirect_index.php';
    }
    else
        require "./redirects/users/redirect_login.php";

};
function VerifyStaffLogin($PDO,$username,$password){

    $RESULT = $PDO->query("SELECT * FROM `staff_accounts` WHERE `username`='$username'");

    if (!$RESULT){
        require("redirects/staff/redirect_login.php");
        exit;
    }

    $ROW = $RESULT->fetch(); //Get row from result(s)

    if (!$ROW){
        require("redirects/staff/redirect_login.php");
        exit;
    }

    $hashed = $ROW['password'];
    if (password_verify($password,$hashed))
    {
        $_SESSION['username'] = $ROW['username']; //User logged in and is saved for this session.
        require("redirects/staff/redirect_index.php");
    }
    else
        require("redirects/staff/redirect_login.php");

};
//Get client ID from username
function GetClientIDFromName($PDO){
    if (isset($_SESSION['username'])){
        $name = $_SESSION['username'];
        $RESULT = $PDO->query("SELECT `id` FROM `client_accounts` WHERE `username`='$name'");
        if ($RESULT){
            return $RESULT->fetch()['id'];
        }else{
            return false;
        }
    }

}
//Get Client Quotes for $staffName
function GetClientQuotesFromStaffName($PDO, $username, $pageNumber=0){

    if (is_int($pageNumber))
    {
        $pageNumber *= 15;
        $RESULTS = $PDO->query("SELECT `client_quotes`.`id`,`client_accounts`.`username` as `clientName`,`staff_accounts`.`username` as `staffName`, `client_quotes`.`status` FROM `client_quotes` 
        LEFT JOIN `staff_accounts` ON `client_quotes`.`staffID` = `staff_accounts`.`id`
        LEFT JOIN `client_accounts` ON `client_quotes`.`clientID` = `client_accounts`.`id`
        WHERE `staff_accounts`.`username`='$username' 
        LIMIT 15 
        OFFSET $pageNumber");

        if (!$RESULTS){
            return []; //Failed empty array
        }
        else{
            return $RESULTS->fetchAll(); //Get all matching results. Can be 0.
        }
    }
};
function GetClientQuotesFromClientName($PDO, $username, $pageNumber=0){

    if (is_int($pageNumber))
    {
        $pageNumber *= 15;
        $RESULTS = $PDO->query("SELECT `client_quotes`.`id`,`staff_accounts`.`username` as `staffName`, `client_quotes`.`status` FROM `client_quotes` 
        LEFT JOIN `staff_accounts` ON `client_quotes`.`staffID` = `staff_accounts`.`id`
        LEFT JOIN `client_accounts` ON `client_quotes`.`clientID` = `client_accounts`.`id`
        WHERE `client_accounts`.`username`='$username' 
        LIMIT 15
        OFFSET $pageNumber");

        if (!$RESULTS){
            return []; //Failed empty array
        }
        else{
            return $RESULTS->fetchAll(); //Get all matching results. Can be 0.
        }
    }
};
function GetQuoteFromID($PDO,$id){
    if (is_int($id)){
        $RESULTS = $PDO->query("SELECT `client_quotes`.`id`,`client_accounts`.`username` as `clientName`,`staff_accounts`.`username` as `staffName`, `client_quotes`.`status` FROM `client_quotes` 
        LEFT JOIN `staff_accounts` ON `client_quotes`.`staffID` = `staff_accounts`.`id`
        LEFT JOIN `client_accounts` ON `client_quotes`.`clientID` = `client_accounts`.`id`
        JOIN `products` ON `client_quotes`.`clientID` = `products`.`quoteID`
        WHERE `client_quotes`.`id`='$id'
        ");

        if (!$RESULTS){
            return [];
        }else{
            return $RESULTS->fetch();
        }
    }
}
function GetQuoteStatus($PDO, $QID){
    $R = $PDO->query("SELECT `status` FROM `client_quotes` WHERE `id`=$QID");
    if ($R)
        return $R->fetch()['status'];
        else
        return false;
}
///CLIENT QUOTE ACTIONS
function CreateNewQuote($PDO){
    $itemArray = $_SESSION['basket'];
    $cID = GetClientIDFromName($PDO);
    $SQL = "INSERT INTO `client_quotes` VALUES (NULL,$cID,NULL,'opened')";
    $RESULT = $PDO->exec($SQL);
    $newID = intval($PDO->lastInsertId());//Must get id before commit.
    if ($RESULT==1){
        $MAXITEMS = count($itemArray);
        $SQL = "INSERT INTO `quote_product` VALUES ";
        $i=0;
        foreach ($itemArray as $value) {
                $vID = $value['productID'];
                $vQT = $value['quantity'];

            $SQL .= "($newID,$vID,$vQT)";
            ++$i;
            if($i < $MAXITEMS){
                $SQL.=", ";
            }
        }

        $RESULT = $PDO->exec($SQL);
        if ($RESULT == $MAXITEMS){
            return true;
        }
    }
    return false;
}
function UpdateQuoteItems($PDO,$QID){
    $itemArray = $_SESSION['basket'];
    $cID = GetClientIDFromName($PDO);
    if(is_int($cID))
    {
        try{

            $PDO->beginTransaction();
            foreach ($itemArray as $key => $value) {
                $SQL = "UPDATE `quote_product` SET `quantity`=$value WHERE `quoteID`=$QID AND `productID`=$key";
                $stmt = $PDO->prepare($SQL);
                $RESULT = $stmt->execute();
            }            
            $PDO->commit();
            UpdateQuoteStatus($PDO,$QID,'opened');
        }
        catch (Exception $e){
            $PDO->rollback();
            print "Error: ".$e->getMessage()."</br>";
        }
    }

}
function UpdateQuoteStatus(PDO $PDO,int $quoteID,string $status){
    
    $SQL = "UPDATE `client_quotes` SET `status`=? WHERE `id`=?";
    $RESULT = $PDO->prepare($SQL)->execute([$status,$quoteID]);
    return $RESULT;
}
function DeleteQuote($PDO,$quoteID){
    $cID = GetClientIDFromName($PDO);
    $qID = $quoteID;
    try {
        $PDO->beginTransaction();
        $SQL = "DELETE FROM `client_quotes` WHERE `id`=:qid AND `clientID`=:cid";
        $stmt = $PDO->prepare($SQL);
        $RESULT = $stmt->execute(array(':qid'=>$qID,':cid'=>$cID));
        
        if ($RESULT){
            if ($PDO->commit())
            return true;
            else
            throw new Exception("PDO Commit fail");
        }
        else{
            throw new Exception("Statement executed invalid. Might be the status is not in enum.");
        }

    } catch (Exception $e) {
        $PDO->rollback();
        print "Error: ".$e->getMessage()."</br>";
    }
}
///ALL MATERIAL MASTERS COMMANDS
//Super basic get all function.
function GetAllProducts($PDO){
    $SQL = "SELECT * FROM `products`";
    $RESULTS = $PDO->query($SQL);
    if(!$RESULTS){
        return [];
    }else{
        return $RESULTS->fetchAll();
    }
}

//Search Products
function SearchProducts($PDO,$productName){
    if(!is_null($productName)){
        $SQL= "SELECT * FROM `products` WHERE  `name` LIKE '%$productName%'";
        $RESULTS = $PDO->query($SQL);
        if (!$RESULTS){
            return [];
        }else{
            return $RESULTS->fetchAll();
        }
}}
//Returns a product from its id.
function GetProductByID($PDO,int $pID){
    if (is_int($pID))
    {
        $SQL = "SELECT * FROM `products` WHERE `id` = $pID";
        $RESULTS = $PDO->query($SQL);
        
        if(!$RESULTS){
            return null;
        }else{
            return $RESULTS->fetch();
        }
    }
}
function GetProductsByIDs($PDO,$idArray){

    $finalArray = implode("','",$idArray);

    $SQL = "SELECT * FROM `products` WHERE `id` IN ('$finalArray')";
    $RESULTS = $PDO->query($SQL);
    
    if(!$RESULTS){
        return null;
    }else{
        return $RESULTS->fetchAll();
    }

}
//Returns [] or array of products for a given quoteID
function GetProductsForQuote($PDO, $qID){
    if (is_int($qID)){
        $SQL = "SELECT * FROM `quote_product`
        LEFT JOIN `products` ON `productID`=`id`
        WHERE `quoteID`=$qID";
        $RESULTS = $PDO->query($SQL);
        if (!$RESULTS){
            return [];
        }else{
            return $RESULTS->fetchAll();
        }
    }
}

///Client account control
function CreateClientAccount($PDO,$name,$pass){
    $SQL = "INSERT INTO `client_accounts` VALUE (NULL,'$name','$pass')";
    $RESULT = $PDO->exec($SQL);
    if ($RESULT===1){
        return true;
    }
    return false;
}

?>