<?php
session_start();
require_once "config.php";


$koszyk = 0;

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $id = isset($_GET["code"]);

    if($_POST["ilosc"]>0){

    if(!empty($_SESSION["produkt_items"])){

        if(in_array($_GET["code"],array_keys($_SESSION["produkt_items"]))){
            foreach($_SESSION["produkt_items"] as $key => $val){
                if($key == $_GET["code"]){
                    $tmp = $val+$_POST["ilosc"];
                    $_SESSION["produkt_items"][$_GET["code"]]= $tmp;
                }
        }
        }else{
             $_SESSION["produkt_items"][$_GET["code"]]= $_POST["ilosc"];
        }
    }else{

        $_SESSION["produkt_items"][$_GET["code"]]= $_POST["ilosc"];

    }  
    

        $sql_cena = "select cena,promocja from produkty where id_produktu = '".$_GET["code"]."'";
        echo $sql_cena;
        $stmt = $mysqli->query($sql_cena);
        $result = $stmt ->fetch_array();
        $suma = $result['cena'] * $_POST["ilosc"];
        if($result["promocja"]>0){
            $suma -= ($suma*$result["promocja"]/100);
        }

        if(!empty($_SESSION['koszyk'])){
            $koszyk = $_SESSION['koszyk'];
            $koszyk += $suma;
        }else{
           $koszyk += $suma; 
        }

        $_SESSION['koszyk']= $koszyk;
    }else{
        if(isset($_SESSION['koszyk'])){
             $koszyk = $_SESSION['koszyk'];
        }

    }
}
           //var_dump($_SESSION);
    



?>