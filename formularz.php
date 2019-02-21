<?php 

session_start(); 
require_once "config.php";

$imie = $nazwisko =$email= $ulica= $kod=$miasto="";
$error = $wiadomosc = "";

$sql_login = "select * from uzytkownicy where id_uzytkownika = '".$_SESSION["id"]."'";

if($stmt=$mysqli->query($sql_login)){
    if($result=$stmt->fetch_array()){
        $imie = $result["imie"];
        $nazwisko =$result["nazwisko"];
        $email= $result["email"];
        $ulica= $result["ulica"];
        $kod=$result["kod"];
        
        $miasto=$result["miasto"];
    }
}

if($_SERVER["REQUEST_METHOD"]== "POST"){
    
    
    if($_POST["wyslij"]){
        
                $numer = rand(1000,10000);
                $temat = "Zamówienie numer ".$numer;
                $tresc = "";
        
        
                foreach($_SESSION["produkt_items"] as $key => $val){
                    $sql = "select nazwa from produkty where id_produktu = '".$key."'";
                    $stmt=$mysqli->query($sql);
                    $row=$stmt->fetch_array();
                    $tresc .= "id: ".$key." nazwa: ".$row["nazwa"]." ilosc: ".$val." \n";
                }
                $tresc.= "Suma do zapłaty wynosi: ".$_SESSION['koszyk']." zł\n";
                
                
                mail($email_to,$temat,$tresc);
                
                header("location: strona_startowa.php");
                $_SESSION["koszyk"]=0;
                unset($_SESSION["produkt_items"]);
        }
        
    if($_POST["anuluj"]){
        header("location: koszyk.php");
    }
 
}


?>

<html>
    <head>
        <meta charset="UTF-8" />
            <title>formularz wysyłki</title>
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
                <form class="kosz" action="koszyk.php" method="post">
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
            <form method="post">
            <div class="box_rej_2">
                    <h2 class="form_h">DANE DO FAKTURY I DOSTAWY</h2>
                    
                    <div class="from_group">
                        <label class="form_label">Imię:<input type="text" name="imie" value="<?php echo $imie; ?>" readonly></label></div>
                    <div class="from_group">
                        <label class="form_label">Nazwisko:<input type="text" name="nazwisko" value="<?php echo $nazwisko; ?> " readonly></label></div>
                    <div class="from_group">
                        <label class="form_label">Ulica i numer:<input type="text" name="ulica" value="<?php echo $ulica; ?>"readonly></label></div>
                    <div class="from_group">
                        <label class="form_label_kod">Kod pocztowy i miasto:<input type="text" name="kod" value="<?php echo $kod; ?>" class="input_kod" readonly><input type="text" name="miasto" value="<?php echo $miasto; ?>" class="input_miasto"readonly></label></div>
                    <div class="from_group">
                        <label class="form_label">Email:<input type="text" name="email" value="<?php echo $email; ?>"readonly></label></div>
                </div>
            
                <div class="btn">
                    <a href="formularz.php?action=wyslij"><input type=submit name="wyslij" class="btn_koszyk" value="wyślij zamówienie" /></a>
            
                    <a href="formularz.php?action=anuluj"><input type=submit name="anuluj" class="btn_koszyk" value="anuluj"/></a>
                </div>
            </form>
        </section>

    </body>
</html>