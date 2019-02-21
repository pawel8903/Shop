<?php 

require_once "strona_index.php";
print_r($_SESSION);
if(!isset($_GET["select"])){
    header("location: strona_startowa.php?select=all");
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST["wyszukiwanie"])){
        $_SESSION["wyszukiwanie"]=$_POST["wyszukiwanie"];
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8" />
            <title>strona startowa</title>
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
            <?php 
                $sql= "";
            if($_GET["select"]=="all"){
                $sql = "select * from produkty";
            }elseif($_GET["select"]=="psy"){
                $sql="select * from produkty where FK_id_rodzaj = 1 ";
            }elseif($_GET["select"]=="koty"){
                $sql="select * from produkty where FK_id_rodzaj = 2";
            }elseif($_GET["select"]=="gryzonie"){
                $sql="select * from produkty where FK_id_rodzaj = 3 ";
            }elseif($_GET["select"]=="ptaki"){
                $sql="select * from produkty where FK_id_rodzaj = 4 ";
            }elseif($_GET["select"]=="akwarystyka"){
                $sql="select * from produkty where FK_id_rodzaj = 5 ";
            }elseif($_GET["select"]=="promocje"){
                $sql="select * from produkty where promocja >0 ";
            }elseif($_GET["select"]=="search"){
                $male = strtolower($_SESSION["wyszukiwanie"]);
                $duze = strtoupper($_SESSION["wyszukiwanie"]);
                $sql="select * from produkty where nazwa like '%".$duze."%' or  '%".$male."%'";
                
            }
                if($result=$mysqli->query($sql)){
                    while($row= $result->fetch_array()){ 
                if($row["ilosc_magazyn"]==0){continue;}?>
            <div class="produkt">
                <form action="strona_startowa.php?action=add&code=<?php echo $row["id_produktu"];?>&select=<?php echo $_GET["select"];?>" method="POST">
                    <div ><img class="produkt_img" src="images/<?php echo $row["nazwa_img"];?>" alt="<?php echo $row["nazwa_img"];?>" /></div>
                    <div class="produkt_nazwa"><b><?php echo $row["nazwa"];?></b></div>
                    <div><span id="promocja"><?php if($row["promocja"]>0){echo "Aktualna cena: ".
                    number_format($row["cena"] -($row["promocja"]*$row["cena"]/100),2,',',' ')." zł";} ?></span></div>
                    <div class="produkt_info">
                        <div class="produkt_cena" name="cena"><?php echo $row["cena"]." zł"?></div>
                        <div class="produkt_ilosc">
                            <input type="text" class="type_ilosc" value="1" name="ilosc">
                            <input type="submit" class="type_submit" value="DODAJ DO KOSZYKA">
                        </div>
                    </div>
                </form>
            </div>
            <?php } }$mysqli->close();?>
                
            
        </section>
        <footer></footer>
    </body>
</html>