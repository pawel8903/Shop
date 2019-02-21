<?php 
session_start();
require_once "config.php";
print_r($_SESSION);
$koszyk = "0.00";
$typ_produktu = array();
$rodzaj_produktu= array();

$sql_typ = "select id_typ_produktu,typ_produktu from typ_produktu";
$stmt=$mysqli->query($sql_typ);
$typ_produktu=$stmt->fetch_all();
$stmt->free();

$sql_typ = "select id,nazwa from rodzaj_produktu";
$stmt=$mysqli->query($sql_typ);
$rodzaj_produktu = $stmt->fetch_all();
$stmt->free();

$sql_typ = "select id_typ_uzytkownika,typ from typ_uzytkownika";
$stmt=$mysqli->query($sql_typ);
$typ_uzytkownika = $stmt->fetch_all();
$stmt->free();

$error_id_insert=$error_login="";

if($_GET["admin"]=="produkty"){
    if(isset($_SESSION["search_uzytkownicy"])){
        unset($_SESSION["search_uzytkownicy"]);
    }
}
if($_GET["admin"]=="uzytkownicy"){
    if(isset($_SESSION["search_produkty"])){
        unset($_SESSION["search_produkty"]);
    }
}
if($_SESSION["typ_uzytkownika"]==3 ||$_SESSION["typ_uzytkownika"]==4 ){
    header("location:strona_startowa.php");
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(!empty($_GET["action"])){
   switch($_GET["action"]){
       case "modify":
           if($_GET["admin"]=="produkty"){
               $sql = "update produkty set nazwa='".$_POST["td_nazwa"]."',nazwa_img='".$_POST["td_nazwa_img"]."', cena='".$_POST["td_cena"]."', ilosc_magazyn='".$_POST["td_ilosc"]."', FK_typ_produktu='".$_POST["typ_produktu"]."', promocja='".$_POST["td_promocja"]."', FK_id_rodzaj='".$_POST["rodzaj_produktu"]."'   where id_produktu = '".$_POST["td_id"]."'";
           $stmt= $mysqli->query($sql);
           }
           if($_GET["admin"]=="uzytkownicy"){
                
                $sql_id= "select id_uzytkownika from uzytkownicy where id_uzytkownika = '".$_POST["td_id"]."'";
                $sql_login= "select login from uzytkownicy where login = '".$_POST["td_login"]."'";
                
                if($stmt=$mysqli->query($sql_id)){
                    if($stmt->num_rows>0){
                        $error_id_insert = "Numer użytkonika jest zajęte. Proszę wpisać nowe lub pozostawić puste.";
                                                echo $error_id_insert;

                    }
                }
                if($stmt=$mysqli->query($sql_login)){
                    if($stmt->num_rows>0){
                        $error_login = "Login zajety. Proszę wprowadzić inny.";
                        echo $error_login;
                    }
                }    
    
              if(empty($error_login)&&empty($error_id_insert)){
                    $sql = "update uzytkownicy set id_uzytkownika='".$_POST["td_id"]."',login='".$_POST["td_login"]."', haslo='".$_POST["td_haslo"]."', email='".$_POST["td_email"]."', FK_typ_uzytkownika='".$_POST["typ_uzytkownika"]."' where id_uzytkownika = '".$_GET["id_uzyt"]."'";
                    if($stmt = $mysqli->query($sql)){}                  
                    }
            } 
           
           break;
       case "add":
           if($_GET["admin"]=="produkty"){
               if($_POST["ilosc"]>0){
               $sql_get = "select ilosc_magazyn from produkty where id_produktu ='".$_GET["id_pro"]."' ";
               
               if($stmt=$mysqli->query($sql_get)){
                    $row = $stmt->fetch_assoc();
                    $stmt->free();
                    $add = strval($row["ilosc_magazyn"]) + $_POST["ilosc"];
                    $sql = "update produkty set ilosc_magazyn = '".$add."' where id_produktu = '".$_GET["id_pro"]."'";
                    $stmt= $mysqli->query($sql);
               } 
           }
           }
            
           break;
       case "removeOne":
           if($_GET["admin"]=="produkty"){
               if($_POST["ilosc"]>0){
               $sql_get = "select ilosc_magazyn from produkty where id_produktu ='".$_GET["id_pro"]."' ";
               
               if($stmt=$mysqli->query($sql_get)){
                    $row = $stmt->fetch_assoc();
                    $stmt->free();
                    $remove = strval($row["ilosc_magazyn"]) - $_POST["ilosc"];
                    if($remove>=0){
                        $sql = "update produkty set ilosc_magazyn = '".$remove."' where id_produktu = '".$_GET["id_pro"]."'";
                        $stmt= $mysqli->query($sql);
                    } 
               } 
           }
           }
           if($_GET["admin"]=="uzytkownicy"){
               $sql ="delete from uzytkownicy where id_uzytkownika ='".$_GET["id_pro"]."'";
               $stmt=$mysqli->query($sql);
           }
           break;
       case "add_row":
            if($_GET["admin"]=="produkty"){
                $sql_id= "select id_produktu from produkty where id_produktu = '".$_POST["td_id"]."'";
                
                
                if($stmt=$mysqli->query($sql_id)){
                    if($stmt->num_rows>0){
                        $error_id_insert = "Numer użytkonika jest zajęte. Proszę wpisać nowe lub pozostawić puste.";
                    }
                }
                
    
              if(empty($error_id_insert)){
                    $sql = "insert into produkty values ('".$_POST["td_id"]."','".$_POST["td_nazwa"]."', '".$_POST["td_nazwa_img"]."', '".$_POST["td_cena"]."', '".$_POST["td_ilosc"]."', '".$_POST["typ_produktu"]."', '".$_POST["td_promocja"]."', '".$_POST["rodzaj_produktu"]."')";
                    if($stmt = $mysqli->query($sql)){}                  
                    }
            }
            if($_GET["admin"]=="uzytkownicy"){
                
                $sql_id= "select id_uzytkownika from uzytkownicy where id_uzytkownika = '".$_POST["td_id"]."'";
                $sql_login= "select login from uzytkownicy where login = '".$_POST["td_login"]."'";
                
                if($stmt=$mysqli->query($sql_id)){
                    if($stmt->num_rows>0){
                        $error_id_insert = "Numer użytkonika jest zajęte. Proszę wpisać nowe lub pozostawić puste.";
                    }
                }
                if($stmt=$mysqli->query($sql_login)){
                    if($stmt->num_rows>0){
                        $error_login = "Login zajety. Proszę wprowadzić inny.";
                    }
                }    
    
              if(empty($error_login)&&empty($error_id_insert)){
                    $sql = "insert into uzytkownicy (id_uzytkownika,login, haslo, email, FK_typ_uzytkownika) values ('".$_POST["td_id"]."','".$_POST["td_login"]."', '".$_POST["td_haslo"]."', '".$_POST["td_email"]."', '".$_POST["typ_uzytkownika"]."')";
                    if($stmt = $mysqli->query($sql)){}                  
                    }
            }
           break;
           case "search":
            if($_GET["admin"]=="produkty"){
                $sql ="select * from produkty where ";
                $licznik =false;
                if(!empty($_POST["nazwa"])){
                    $sql.= "nazwa='".$_POST["nazwa"]."'";
                    $licznik=true;
                }
                if(!empty($_POST["nazwa_img"])){
                    if($licznik){
                        $sql.= ",nazwa_img='".$_POST["nazwa_img"]."'";
                    }else{
                        $sql.= "nazwa_img='".$_POST["nazwa_img"]."'";
                        $licznik=true;
                    }
                }
                if(!empty($_POST["typ_produktu"])){
                    if($licznik){
                        $sql.= ",FK_typ_produktu='".$_POST["typ_produktu"]."'";
                    }else{
                        $sql.= "Fk_typ_produktu='".$_POST["typ_produktu"]."'";
                        $licznik=true;
                    }
                }
                if(!empty($_POST["rodzaj_produktu"])){
                    if($licznik){
                        $sql.= ",FK_id_rodzaj='".$_POST["rodzaj_produktu"]."'";
                    }else{
                        $sql.= "FK_id_rodzaj='".$_POST["rodzaj_produktu"]."'";
                        $licznik=true;
                    }
                }
                echo $sql;
                
                if($sql != "select * from produkty where "){
                    if($stmt=$mysqli->query($sql)){
                       echo $sql;
                        $result=$stmt->fetch_all();
                        $_SESSION["search_produkty"]=$sql;
                        print_r($_SESSION["search_produkty"]); 
                    }
                    
                }else{
                    if(isset($_SESSION["search_produkty"])){
                        unset($_SESSION["search_produkty"]);
                    }
                }
            }
            if($_GET["admin"]=="uzytkownicy"){
                $sql ="select * from uzytkownicy where ";
                $licznik =false;
                if(!empty($_POST["login"])){
                    $sql.= "login='".$_POST["login"]."'";
                    $licznik=true;
                }
                if(!empty($_POST["haslo"])){
                    if($licznik){
                        $sql.= ",haslo='".$_POST["haslo"]."'";
                    }else{
                        $sql.= "haslo='".$_POST["haslo"]."'";
                        $licznik=true;
                    }
                }
                if(!empty($_POST["email"])){
                    if($licznik){
                        $sql.= ",email='".$_POST["email"]."'";
                    }else{
                        $sql.= "email='".$_POST["email"]."'";
                        $licznik=true;
                    }
                }
                if(!empty($_POST["typ_uzytkownika"])){
                    if($licznik){
                        $sql.= ",FK_typ_uzytkownika='".$_POST["typ_uzytkownika"]."'";
                    }else{
                        $sql.= "FK_typ_uzytkownika='".$_POST["typ_uzytkownika"]."'";
                        $licznik=true;
                    }
                }
                if($sql != "select * from uzytkownicy where "){
                    $stmt=$mysqli->query($sql);
                    echo $sql;
                    $result=$stmt->fetch_all();
                    $_SESSION["search_uzytkownicy"]=$sql;
                    print_r($_SESSION["search_uzytkownicy"]);
                }else{
                    if(isset($_SESSION["search_uzytkownicy"])){
                        unset($_SESSION["search_uzytkownicy"]);
                    }
                }
            }
           break;
        }
    }
}

?>

<html>
    <head>
        <meta charset="UTF-8" />
            <title>pulpit administratora</title>
        <meta name="description" content="Strona rejestracji do portalu" />
        <meta name="keywords" content="rejesracja,portal,login,haslo" />
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
            <form  id="search_form" method="post" action="">
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
            </ol>
            <ol>
                <li><a href="pulpit_administratora.php?admin=produkty">Produkty</a></li>
                <li><a href="pulpit_administratora.php?admin=uzytkownicy">Uzytkownicy</a></li>
            </ol>
        </nav>
        <section class="panel_admina">
            <?php if($_GET["admin"]=="produkty"){?>
            <div class="search_section">
                <form method="post" action="pulpit_administratora.php?admin=produkty&action=search">
                <label>Nazwa:<input type="text" name="nazwa"></label>
                <label>Nazwa img:<input type="text" name="nazwa_img"></label>
                <label>Cena od:<input type="text" name="cena_od">Cena do:<input type="text" name="cena_do"></label>
                <label>Ilość od:<input type="text" name="ilosc_od">Ilość do :<input type="text" name="ilosc_do"></label>
                <label>Rodzaj produktu:
                <select name="typ_produktu">
                    <option value=""></option>
                    <?php foreach($rodzaj_produktu as $val){ ?>
                    <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option><?php }?>                  
                </select>    
                </label>
                <label>Typ produktu:
                <select name="rodzaj_produktu">
                    <option value=""></option>
                    <?php foreach($typ_produktu as $val){?>
                    <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option> <?php }?>
                </select>    
                </label>
               
                <label>Promocje<input type="checkbox" name="promocja"></label>
                <input type="submit" value="szukaj">
                </form>
            </div>
            <div class="wyniki">
                <table>
                     <thead>
                        <tr>
                            <td width="3%;">Numer</td>
                            <td width="18%;">Nazwa</td>
                            <td width="18%;">Nazwa img</td>
                            <td width="7%;">Ilość na magazynie</td>
                            <td width="7%">Cena jednostkowa</td>
                            <td width="10%;">Rodzaj produktu</td>
                            <td width="10%;">Typ produktu</td>
                            <td width="6%;">Promocja</td>
                            <td width="6%;">Modifikuj</td>
                            <td width="7%;">Dodaj</td>
                            <td width="7%;">Usuń</td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="add_row">
                        <form method="post" action="pulpit_administratora.php?admin=produkty&action=add_row">
                        <td><input type="text" name="td_id" size="4%"></td>
                        <td><input type="text" name="td_nazwa" size="28%"></td>
                        <td><input type="text" name="td_nazwa_img" size="28%"></td>
                        <td><input type="text" name="td_ilosc"size="5%" ></td>
                        <td><input type="text" name="td_cena" size="5%"></td>
                        <td>
                            <select name="typ_produktu">
                                <option value=""></option>
                                <?php foreach($rodzaj_produktu as $val){ ?>
                                <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option><?php }?>
                            </select>
                        </td>
                        <td>
                            <select name="rodzaj_produktu">
                                <option value=""></option>
                                <?php foreach($typ_produktu as $val){ ?>
                                <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option><?php }?>
                            </select>
                        </td>
                        <td><input type="text" name="td_promocja" size="5%"></td>
                        <td></td>
                        <td ><button  class="icon-plus"></button></td>
                        <td></td>
                        </form>
                        </tr>
                            <?php $sql_produkty = "select * from produkty";
                            if(isset($_SESSION["search_produkty"])){
                                $sql_produkty= $_SESSION["search_produkty"];
                            }
                            $stmt= $mysqli->query($sql_produkty);
                            while($row=$stmt->fetch_array()){?>
                        <tr id="tr_list">
                            <form method="post" action="pulpit_administratora.php?action=modify&admin=produkty">
                                <td><input type="text" name="td_id" size="4%" value="<?php echo $row['id_produktu'];?>"></td>
                                <td><input type="text" name="td_nazwa"size="28%" value="<?php echo $row['nazwa'];?>"></td>
                                <td><input type="text" name="td_nazwa_img" size="28%" value="<?php echo $row['nazwa_img'];?>"></td>
                                <td><input type="text" name="td_ilosc" size="5%" value="<?php echo $row['ilosc_magazyn'];?>"></td>
                                <td><input type="text" name="td_cena" size="5%" value="<?php echo $row['cena'];?>"></td>
                                <td>
                                    <select name="typ_produktu">
                                        <?php foreach($rodzaj_produktu as $val){ 
                                        if($row["FK_typ_produktu"]==$val[0]){?>
                                        <option value="<?php echo $val[0];?>" selected><?php echo $val[1];?></option>
                                        <?php }else{?>
                                        <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option>
                                        <?php }}?>
                                        
                                    </select>
                                </td>
                                <td>
                                    <select name="rodzaj_produktu">
                                        <?php foreach($typ_produktu as $val){ 
                                        if($row["FK_typ_produktu"]==$val[0]){?>
                                        <option value="<?php echo $val[0];?>" selected><?php echo $val[1];?></option>
                                        <?php }else{?>
                                        <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option>
                                        <?php }}?>
                                        
                                    </select>
                                </td>
                                
                                <td><input type="text" name="td_promocja" size="5%" value="<?php echo $row['promocja'];?>"></td>
                                <td><button class="icon-up-circled2"></button></td>
                            </form>
                            <td><form method="post" action="pulpit_administratora.php?action=add&id_pro=<?php echo $row['id_produktu'];?>&admin=produkty" class="from_table">
                            <input type="text" class="type_ilosc" value="1" name="ilosc" width="30px;">
                            <button class="icon-plus"></button>
                            </form></td>
                            <td>
                            <form method="post" action="pulpit_administratora.php?action=removeOne&id_pro=<?php echo $row['id_produktu'];?>&admin=produkty" class="from_table">
                            <input type="text" class="type_ilosc" value="1" name="ilosc">
                            <button class="icon-trash"></button>
                            </form></td>
                            
                        </tr>    
                            <?php }?>
                        
                    </tbody>
                </table>
            </div>
            <?php }?>
            
            
            <?php if($_GET["admin"]=="uzytkownicy"){?>
            <div class="search_section2">
                <form method="post" action="pulpit_administratora.php?admin=uzytkownicy&action=search">
                <label>Login:<input type="text" name="login"></label>
                <label>Hasło:<input type="text" name="haslo"></label>
                <label>Email:<input type="email" name="email"></label>
                <label>Typ użytkownika
                <select name="typ_uzytkownika">
                    <option value=""></option>
                    <?php foreach($typ_uzytkownika as $val){ ?>
                    <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option><?php }?>
                </select>    
                </label>
                
                <input type="submit" value="szukaj">
                </form>
            </div>
            <div class="wyniki2">
                <table>
                     <thead>
                        <tr>
                            <td width="4%;">Numer</td>
                            <td width="15%;">Login</td>
                            <td width="15%;">Hasło</td>
                            <td width="10%;">Email</td>
                            <td width="10%">Typ użytkownika</td>
                            <td width="10%;">Dodaj</td>
                            <td width="10%;">Modifikuj</td>
                            <td width="10%;">Usuń</td>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="add_row">
                        <form method="post" action="pulpit_administratora.php?action=add_row&admin=uzytkownicy">
                        <td><input type="text" name="td_id" ></td>
                        <td><input type="text" name="td_login"></td>
                        <td><input type="text" name="td_haslo"></td>
                        <td><input type="text" name="td_email"></td>
                        <td>
                            <select name="typ_uzytkownika">
                                <?php foreach($typ_uzytkownika as $val){ ?>
                                <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option><?php }?>
                            </select>
                        </td>
                        <td><button class="icon-plus"></button></td>
                        <td></td>
                        <td></td>
                        </form>
                        </tr>
                            <?php $sql_uzytkownicy = "select * from uzytkownicy";
                            if(isset($_SESSION["search_uzytkownicy"])){
                                $sql_uzytkownicy= $_SESSION["search_uzytkownicy"];
                            }
                            $stmt= $mysqli->query($sql_uzytkownicy);
                            while($row=$stmt->fetch_array()){?>
                        <tr id="tr_list">
                            <form method="post" action="pulpit_administratora.php?action=modify&admin=uzytkownicy&id_uzyt=<?php echo $row["id_uzytkownika"];?>">
                                <td><input type="text" name="td_id" value="<?php echo $row['id_uzytkownika'];?>"></td>
                                <td><input type="text" name="td_login"value="<?php echo $row['login'];?>"></td>
                                <td><input type="text" name="td_haslo"value="<?php echo $row['haslo'];?>"></td>
                                <td><input type="text" name="td_email"value="<?php echo $row['email'];?>"></td>
                                <td>
                                    <select name="typ_uzytkownika">
                                        <?php foreach($typ_uzytkownika as $val){ 
                                        if($row["FK_typ_uzytkownika"]==$val[0]){?>
                                        <option value="<?php echo $val[0];?>" selected><?php echo $val[1];?></option>
                                        <?php }else{?>
                                        <option value="<?php echo $val[0];?>"><?php echo $val[1];?></option>
                                        <?php }}?>
                                        
                                    </select>
                                </td>
                            <td></td>
                            <td><button class="icon-up-circled2"></button></td>
                            </form>
                            
                            <td>
                            <form method="post" action="pulpit_administratora.php?action=removeOne&id_pro=<?php echo $row['id_uzytkownika'];?>&admin=uzytkownicy">
                            <button class="icon-trash"></button>
                            </form></td>
                        </tr>    
                            <?php }?>
                        
                    </tbody>
                </table>
            </div>
            <?php }?>

            
            
            
        </section>
        <footer>
        
        </footer>
        
        
        
    </body>
</html>