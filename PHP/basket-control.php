<?php

function GetBasket(){
    if (!isset($_SESSION['basket'])){
        ResetBasket();
    }
    return $_SESSION['basket'];
}
function ResetBasket(){
    $_SESSION['basket'] = [];
}
function AddToBasket($productID, $quantity){
    $key = array_search($productID,array_column(GetBasket(),'productID'));
    if ($key !== false){ //Update existing item
        $_SESSION['basket'][$key]['quantity'] += $quantity;
    }else{//Insert new item
        $item = ["productID"=>$productID,"quantity"=>$quantity];
        array_push($_SESSION['basket'],$item);
    }
}
function RemoveFromBasket($productID,$reduction=1){
    if ($reduction>0 && is_int($productID)){
        $key = array_search($productID,array_column(GetBasket(),'productID'));
        if ($_SESSION['basket'][$key]['quantity'] > $reduction){
            $_SESSION['basket'][$key]['quantity'] -= $reduction;
        }else{
            unset($_SESSION['basket'][$key]);
        }
    }
}



?>