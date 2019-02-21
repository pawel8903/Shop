<?php 
require_once "config.php";
session_start();
$koszyk=0;

$error_login = $error_haslo = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $login = $_POST["login"];
    $haslo = $_POST["pass"];
    
    if(empty($_POST["login"])){
        $error_login = "Login pusty. Proszę uzupełnić.";
    }
    if(empty($_POST["pass"])){
        $error_haslo = "Hasło puste. Proszę usupełnić.";
    }
    if(!empty($_POST["login"])){
        $sql_login = "select id_uzytkownika,login,haslo, FK_typ_uzytkownika from uzytkownicy where login = '".$login."'";
        
        if(strpos($login,"@")){
            $sql_login ="select id_uzytkownika,email,haslo,FK_typ_uzytkownika from uzytkownicy where email= '".$login."'";
        }
        
        if($stmt= $mysqli->query($sql_login)){
            if($stmt->num_rows >= 1){
                $result=$stmt->fetch_array();
                if($haslo == $result["haslo"]){
                
                $_SESSION["id"]=$result["id_uzytkownika"];
                $_SESSION["log_in"]=true;
                $_SESSION["typ_uzytkownika"]= $result["FK_typ_uzytkownika"];
                
                if($result["FK_typ_uzytkownika"] == 3 || $result["FK_typ_uzytkownika"] == 4){
                    header("location: strona_startowa.php?select=all");
                }else{
                    header("location: pulpit_administratora.php?admin=produkty");
                }
                
                }else{
                
                $error_haslo = "Hasło lub login nie poprawne";
                }
            }else{
                $error_haslo = "Hasło lub login nie poprawne";
            }
        }else{
            $error_haslo = "Hasło lub login nie poprawne";
        } 
    }
    
}
?>

<html>
    <head>
        <meta charset="UTF-8" />
            <title>logowanie</title>
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
                <div class="zaloguj">  
                    <a href="logowanie.php" ><i class="icon-user-o"></i>
                        <div>Zaloguj się</div></a>
                </div>
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
        </nav>
        <section id="section_logowanie">
            <div class="span_div"><span><p><?php echo $error_login; ?></p><p><?php echo $error_haslo; ?></p></span></div>
            <h1 class="form_h">Logowanie do konta</h1>
            <div class="box_rej_5">
                <h2 class="form_h">REJESTRACJA</h2>
                <div><p>Jeśli wcześniej nie założyłeś konta w naszym sklepie, zostaniesz poproszony o podanie swoich danych osobowych i adresu dostawy.</p></div>
                <div><a href="rejestracja.php"><input id="btn_reg" type="submit" name="btn_rejestracja" class="btn_koszyk" value="ZAŁÓŻ NOWE KONTO"></a></div>
            </div>
            <div class="box_rej_5">
                <h2 class="form_h">LOGOWANIE</h2>
                <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="from_group">
                    <label class="form_label">Login/E-mail:<input type="text" name="login"></label></div>
                    <div class="from_group">
                    <label class="form_label">Hasło:<input type="password" name="pass"></label></div>
                    
                    <input type="submit" class="btn_koszyk" id="zaloduj" value="ZALOGUJ SIĘ">
                </form>
                <a href="#"><input id="btn_reset" type="submit" name="btn_rejestracja" class="btn_koszyk" value="Nie pamietasz loginu lub hasła?"></a>
            </div>
        </section>
    </body>
</html>