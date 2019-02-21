<?php 
require_once "config.php";
session_start();

$koszyk=0;

if(!empty($_GET["action"])){
    switch($_GET["action"]){
        case "remove":
            session_destroy();
            header("location: strona_startowa.php?select=all");
            break;
        case "removeOne":
            if(isset($_SESSION["produkt_items"])){
                $val = $_SESSION["produkt_items"][$_GET["id_pro"]];
                $tmp = $val - $_POST["ilosc"];
                    if($tmp > 0){
                        $_SESSION["produkt_items"][$_GET["id_pro"]]= $tmp;
                        $sql = "Select cena,promocja from produkty where id_produktu =  '".$_GET["id_pro"]."'";
                        $stmt = $mysqli->query($sql);
                        $result=$stmt->fetch_array();
                        $tmp2 = $result["cena"]*$_POST["ilosc"];
                        if($result["promocja">0]){
                            $tmp2 -= ($tmp2*$result["promocja"]/100);
                        }
                        $_SESSION["koszyk"] = $_SESSION["koszyk"]-$tmp2;
                
                    }else{
                        unset($_SESSION["produkt_items"][$_GET["id_pro"]]);
                        $sql = "Select cena,promocja from produkty where id_produktu =  '".$_GET["id_pro"]."'";
                        $stmt = $mysqli->query($sql);
                        $result=$stmt->fetch_array();
                        $tmp2 = $result["cena"]*$val;
                        if($result["promocja">0]){
                            $tmp2 -=($tmp2*$result["promocja"]/100);
                        }
                        $_SESSION["koszyk"] = $_SESSION["koszyk"]-$tmp2;
                
                    }
                if(empty($_SESSION["produkt_items"])){
                    $_SESSION["koszyk"]=0;
                }
            }
                
            break;
        case "add":
                $val = $_SESSION["produkt_items"][$_GET["id_pro"]];
                $_SESSION["produkt_items"][$_GET["id_pro"]] = $val + $_POST["ilosc"];        
                $sql = "Select cena,promocja from produkty where id_produktu =  '".$_GET["id_pro"]."'";
                $stmt = $mysqli->query($sql);
                $result=$stmt->fetch_array();
                $tmp2 = $result["cena"]*$_POST["ilosc"];
                if($result["promocja">0]){
                    $tmp2 -= ($tmp2*$result["promocja"]/100);
                }
                $_SESSION["koszyk"] = $_SESSION["koszyk"]+$tmp2;
            break;
        case "czyZalogowany":
            if(!isset($_SESSION["log_in"])){
                header("location: logowanie.php?");
            }else{
                header("location: formularz.php");
            }
            break;
    }
}

    

?>

<html>
    <head>
        <meta charset="UTF-8" />
            <title>Koszyk</title>
        <meta name="description" content="Przykładowy sklep" />
        <meta name="keywords" content="dodawanie, usuwanie, karma, pies, zoo, zoologiczny" />
        <meta name="author" content="Paweł Sajnaj" />
        <link href="style.css" type="text/css" rel="stylesheet" />
        <link href="fontello/css/fontello.css" type="text/css" rel="stylesheet" />

    </head>
    <body>
        <header>
            <div id="floating_box">
            <div class="empty_div"></div>
            <div id="main_img"><a href="strona_startowa.php?select=all"><img src="images/how-to-draw-a-cartoon-dog-step-8.jpg" ></a></div>
            <div class="box1" id="form_box">
            <form  id="search_form" method="post" action="strona_startowa.php?select=search">
                <div class="search"><input id="search_text"  type="text"  name="wyszukiwanie"></div>
                <button id="search_btn" class="search"  type="submit" ><i class="icon-search"></i></button>
            </form>
                </div>
            <div class="box1" id="zaloguj_box">
                <?php if(!isset($_SESSION["log_in"]) ){ ?>
                <div class="zaloguj">  
                    <a href="logowanie.php" ><i class="icon-user-o"></i>
                        <div>Zaloguj się</div></a>
                </div>
                <?php }?>
                <?php if(isset($_SESSION["log_in"]) && $_SESSION["log_in"]===true){ ?>
                <div class="zaloguj">  
                    <a href="logout.php" ><i class="icon-user-o"></i>
                        <div>Wyloguj się</div></a>
                </div>
                <?php } ?>
                <div class="zaloguj">
                    <a href="#" ><i class="icon-heart-empty"></i>
                    <div>Ulubione</div></a>
                </div>
            </div>
            <div class="box1" id="koszyk_box">
                <h3 id="suma" class="kosz" ><i class="icon-basket"></i><?php if(isset($_SESSION["koszyk"])){echo number_format($_SESSION["koszyk"],2,',',' ');}else{echo number_format($koszyk,2,',',' ')." zł";}?></h3>
                <form class="kosz" action="koszyk.php" method="post?action=move">
                <button type="submit" id="btn-kosz">Koszyk</button>
                </form>
            </div>
            </div>
        </header>
        <nav>
            <ol>
                <li><a href="strona_startowa.php?select=psy" class="icon-angle-down">PSY </a></li>
                <li><a href="strona_startowa.php?select=koty" class="icon-angle-down">KOTY</a></li>
                <li><a href="strona_startowa.php?select=gryzonie" class="icon-angle-down">GRYZONIE</a></li>
                <li><a href="strona_startowa.php?select=ptaki" class="icon-angle-down">PTAKI</a></li>
                <li><a href="strona_startowa.php?select=akwarystyka" class="icon-angle-down">AKWARYSTYKA</a></li>
                <li><a href="strona_startowa.php?select=promocje" >PROMOCJE</a></li>
                <li><a href="#" >POMOC</a></li>
                <?php if(isset($_SESSION["typ_uzytkownika"])){
                if($_SESSION["typ_uzytkownika"]==1 || $_SESSION["typ_uzytkownika"]==2){?>
                <li><a href="pulpit_administratora.php?admin=produkty">Produkty</a></li>   <li><a href="pulpit_administratora.php?admin=uzytkownicy">Użytkownicy</a></li><?php } }?>
            </ol>
        </nav>
        <section>
        <?php if(!isset($_SESSION["produkt_items"])|| empty($_SESSION["produkt_items"])){?>
        <div class="message"><h1>Koszyk jest pusty</h1></div>
        <a href="strona_startowa.php?select=all"><input class="btn_koszyk" type="submit"  value="Wróć"></a>
        <?php }else{?>
        
        <table id="table_koszyk">
            <thead>
                <tr class="tr_main" width="100%;">
                    <td width="4%;">Numer</td>
                    <td width="50%;">Nazwa</td>
                    <td width="5%;">Ilość</td>
                    <td width="10%">Cena jednostkowa</td>
                    <td width="8%;">Wartość</td>
                    <td width="9%;">Dodaj</td>
                    <td width="9%;">Usuń</td>
                </tr>
            </thead>
            <tbody>
                <?php $tmp = 0;
                $sumaJednostkowa = 0;
                $suma = 0;
                foreach($_SESSION["produkt_items"] as $key => $val){
                    $sql ="select id_produktu,nazwa,nazwa_img, cena,promocja from produkty where id_produktu = '".$key."'";
                    $stmt=$mysqli->query($sql);
                    $row = $stmt->fetch_array();
                    $tmp += $val;
                    $cena = $row["cena"];
                    $suma_jednostkowa = $row["cena"]*$val;
                    if($row["promocja"]>0){
                        $cena -= ($cena*$row["promocja"]/100);
                        $suma_jednostkowa -= ($suma_jednostkowa*$row["promocja"]/100);
                    }
                ?>    
                <tr id="tr_list">
                    <td><?php echo $row["id_produktu"];?></td>
                    <td style="text-align: left;"><div class="img_div"><img src="images/<?php echo $row["nazwa_img"];?>">
                    <b><?php echo $row["nazwa"];?></b></div></td>
                    <td><?php echo $val;?></td>
                    <td><?php echo number_format($cena,2,',',' ')." zł";?></td>
                    <td><?php echo number_format($suma_jednostkowa,2,',',' ')." zł";?></td>
                    <td><form method="post" action="koszyk.php?action=add&id_pro=<?php echo $key;?>">
                        <input type="text" class="type_ilosc" value="1" name="ilosc" >
                        <button class="icon-plus"></button>
                        </form></td>
                    <td>
                    <form method="post" action="koszyk.php?action=removeOne&id_pro=<?php echo $key;?>">
                        <input type="text" class="type_ilosc" value="1" name="ilosc">
                        <button class="icon-trash"></button>
                        </form></td>
                </tr>  
            <?php $suma +=$suma_jednostkowa; }?>
            </tbody>
            <tfoot>
                <tr class="tr_foot">
                    <td style="text-align: right; padding-right: 20px;" colspan="2">Suma:</td>
                    <td style="text-align: center;" colspan="5"><?php echo number_format($suma,2,',',' ')." zł"; ?></td>
                   
                </tr>
            </tfoot>
        </table>    
        <div class="btn_input">
            <a href="strona_startowa.php?select=all"><input class="btn_koszyk" type="submit"  value="Wróć"></a>
            <a href="koszyk.php?action=remove"><input class="btn_koszyk" type="submit"  value="Wyczyść koszyk"></a>
            <a href="koszyk.php?action=czyZalogowany">
                <input class="btn_koszyk" type="submit"  value="Przejdź dalej"></a>  
        </div>
        
        <?php }?>
        
        </section>
    </body>
</html>