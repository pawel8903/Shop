<?php 
require_once "config.php";
session_start();
$koszyk=0;

$imie=$nazwisko=$login=$haslo=$powtorz_haslo=$email=$ulica=$miasto=$kod=$telefon=$nazwa_firmy=$imie2=$nazwisko2=$ulica2=$kod2=$email2=$telefon2=$miasto2=$nazwa_firmy2 = "";
$error_empty =$error_haslo_dlugosc= $error_repeat_haslo= $error_login= $error_email=$error_regulamin="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
$imie=$_POST["imie"]; $nazwisko=$_POST["nazwisko"]; $login=$_POST["login"]; $haslo=$_POST["pass"]; $powtorz_haslo=$_POST["repeat_pass"]; $email=$_POST["email"]; $ulica=$_POST["ulica"]; $miasto=$_POST["miasto"]; $kod=$_POST["kod"]; $telefon=$_POST["telefon"]; $nazwa_firmy=$_POST["nazwa_firmy"]; $imie2=$_POST["imie2"]; $nazwisko2=$_POST["nazwisko2"]; $ulica2=$_POST["ulica2"]; $kod2=$_POST["kod2"];  $telefon2=$_POST["telefon2"]; $miasto2=$_POST["miasto2"]; $nazwa_firmy2 =$_POST["nazwa_firmy2"];
    
    if(empty($imie)|| empty($nazwisko)|| empty($login)|| empty($haslo)|| empty($powtorz_haslo)|| empty($email)|| empty($ulica)|| empty($miasto)|| empty($kod)|| empty($telefon)){
        $error_empty = "Niektóre pola są puste. Proszę poprawić.";
    }
    if(!empty($_POST['login'])){
        $sql_login = "select login from uzytkownicy where login = '".$login."'";
        $stmt= $mysqli->query($sql_login);
        if($stmt->num_rows >= 1){
            $error_login = "Login zajęty proszę wpisać nowy.";
        }
    }
    if(!empty($_POST['email'])){
        
        $sql_email = "select email from uzytkownicy where email = '".$email."'";
        echo $sql_email;
        $stmt= $mysqli->query($sql_email);
        if($stmt->num_rows >= 1){
            $error_email = "Email zajęty proszę wpisać nowy.";
        }
    }
    if(!empty($_POST["pass"])){
        if(strlen(trim($_POST["pass"]))<6){
            $error_haslo_dlugosc= "Hasło musi zawierać conamniej 6 znaków.";
            
        }
        if(strlen(trim($_POST["pass"]))>12){
            $error_haslo_dlugosc = "Hasło musi zawierać maksymalnie 12 znaków.";
            
        }
        if(trim($_POST["pass"])!=trim($_POST["repeat_pass"])){
            $error_repeat_haslo = "Hasła i potwierdz hasło różnią się.";
        }
    }
    if(!isset($_POST["regulamin"])){
        $error_regulamin="Należy zaznaczyć że zapoznano się z regulaminem.";
    }
    
    if(empty($error_empty)&& empty($error_haslo_dlugosc)&& empty($error_repeat_haslo)&& empty($error_login) &&empty($error_email)&&empty($error_regulamin)){
        
        $typ_uzytkownika = "";
        if($_POST["rodzaj_uzytkownik"]=="osoba_fizyczna"){
            $typ_uzytkownika = 3;
        }else{
            $typ_uzytkownika = 4;
        }
        
        $sql = "insert into uzytkownicy values (null,'".$login."','".$haslo."','".$imie."','".$nazwisko."','".$miasto."','".$ulica."', '".$kod."','".$email."','".$telefon."','".$typ_uzytkownika."', '".$nazwa_firmy."')";
        
        $stmt=$mysqli->query($sql);
        
        header("location: logowanie.php");
        //if($_POST["inny_adres"]== "tak")
    }else{
        $haslo = $powtorz_haslo ="";
    }
    
}

?>

<html>
    <head>
        <meta charset="UTF-8" />
            <title>rejestracja</title>
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
            <div class="span_div"><span><p><?php echo $error_empty; ?></p><p><?php echo $error_haslo_dlugosc; ?></p><p><?php echo $error_repeat_haslo; ?></p><p><?php echo $error_login; ?></p><p><?php echo $error_email; ?></p><p><?php echo $error_regulamin; ?></p></span></div>
            <form method="post" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="box_rej_1">
                <h2 class="form_h">POŁĄCZ KONTA Z INNYM SERWISEM</h2>
                <p>tu powinny byc linki do logowania się przez facebooka i google plus</p>
                </div>
                <div class="box_rej_2">
                    <h2 class="form_h">DANE DO FAKTURY I DOSTAWY</h2>
                    <div class="from_group">
                        <div id="form_radio"><label class="form_label_radio">Zamawiasz jako:</label></div>
                        <div id="form_radio" class="form_label_radio1"><label ><input type="radio" name="rodzaj_uzytkownik" value="osoba_fizyczna" checked>Osoba prywatna<input type="radio" name="rodzaj_uzytkownika" value="firma">Firma</label></div>
                    </div>
                    <div class="from_group">
                        <label class="form_label">Imię:<input type="text" name="imie" value="<?php echo $imie; ?>" ></label></div>
                    <div class="from_group">
                        <label class="form_label">Nazwisko:<input type="text" name="nazwisko" value="<?php echo $nazwisko; ?>"></label></div>
                    <div class="from_group">
                        <label class="form_label">Ulica i numer:<input type="text" name="ulica" value="<?php echo $ulica; ?>"></label></div>
                    <div class="from_group">
                        <label class="form_label_kod">Kod pocztowy i miasto:<input type="text" name="kod" value="<?php echo $kod; ?>" class="input_kod"><input type="text" name="miasto" value="<?php echo $miasto; ?>" class="input_miasto"></label></div>
                    <div class="from_group">
                        <label class="form_label">Nazwa firmy:<input type="text" name="nazwa_firmy" value="<?php echo $nazwa_firmy; ?>"></label></div>
                </div>
                <div class="box_rej_2">
                <h2 class="form_h">DOSTAWA NA INNY ADRES</h2>
                    <div class="from_group">
                        <div id="form_radio"><label class="form_label_radio">Dostawa na inny adres:</label></div>
                        <div id="form_radio" class="form_label_radio1"><label><input type="radio" name="inny_adres" value="nie" checked>Nie<input type="radio" name="inny_adres" value="tak">Tak</label></div>
                    </div>
                    <div class="from_group">
                    <label class="form_label">Imię:<input type="text" name="imie2" value="<?php echo $imie2; ?>"></label></div>
                    <div class="from_group">
                    <label class="form_label">Nazwisko:<input type="text" name="nazwisko2" value="<?php echo $nazwisko; ?>"></label></div>
                    <div class="from_group">
                    <label class="form_label">Nazwa firmy:<input type="text" name="nazwa_firmy2" value="<?php echo $nazwa_firmy2; ?>"></label></div>
                    <div class="from_group">
                    <label class="form_label">Ulica i numer:<input type="text" name="ulica2" value="<?php echo $ulica2; ?>"></label></div>
                    <div class="from_group">
                    <label class="form_label_kod">Kod pocztowy i miasto:<input type="text" name="kod2" value="<?php echo $kod2; ?> " class="input_kod"><input type="text" name="miasto2" value="<?php echo $miasto2; ?>" class="input_miasto"></label></div>
                    <div class="from_group">
                    <label class="form_label">Telefon:<input type="tel" name="telefon2" value="<?php echo $telefon2; ?>"></label></div>
                </div>
                <div class="box_rej_3">
                    <h2 class="form_h">DANE KONTAKTOWE</h2>
                    <div class="from_group">
                        <label class="form_label">Adres e-mail:<input type="email" name="email" value="<?php echo $email; ?>"></label></div>
                    <div class="newslatter">
                        <label ><input type="checkbox" name="news_email" checked>Chę otrzymywać E-mail Newsletter(możliwość późniejszej rezygnacji)</label></div>
                    <div class="from_group">
                        <label class="form_label">Telefon: <input type="tel" name="telefon" value="<?php echo $telefon; ?>"></label></div>
                    <div class="newslatter">
                        <label><input type="checkbox" name="news_sms">Chcę otrzymywać SMS Newsletter(możliwość późniejszej rezygnacji)</label></div>
                </div>
                <div class="box_rej_3">
                    <h2 class="form_h">DANE DO LOGOWANIA</h2>
                    <div class="from_group">
                        <label class="form_label">Login:<input type="text" name="login" value="<?php echo $login; ?>"></label></div>
                    <div class="from_group">
                        <label class="form_label">Hasło:<input type="password" name="pass" value="<?php echo $haslo; ?>"></label></div>
                    <div class="from_group">
                        <label class="form_label">Powtórz hasło:<input type="password" name="repeat_pass" value="<?php echo $powtorz_haslo; ?>"></label></div>
                </div>
                <div class="box_rej_4">
                    <label><input type="checkbox" name="regulamin">*Akceptuję warunki <a href="regulami.html">regulaminu</a>. Zgadzam się na otrzymywanie informacji dotyczących zamówień w myśl ustawy z dnia 18 lipca 2002r. o świadczeniu usług drogą elektroniczną.</label>
                    <input id="btn_reg" type="submit" name="btn_rejestracja" class="btn_koszyk" value="ZAREJESTRUJ KONTO">
                    <p>* Pola oznaczone gwiazdką są wymagane</p>
                </div>
            </form>
        </section>
    </body>
</html>