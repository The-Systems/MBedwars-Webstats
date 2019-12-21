<!DOCTYPE HTML>

<?php

require 'mojang-api.class.php';
include("config.php");

$pdo = new PDO('mysql:host='.$ip.';dbname='.$database.'', $user, $password);

if(!isset($_POST['username'])){
	header('Location: '.$domain);
 }
?>

<html>
<head>
    <title><?php echo $richname; ?></title>
    <meta name="description" content="<?php echo $richtext; ?>">
    <meta name="theme-color" content="#424242">
    <meta charset="UTF-8">	
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		</noscript>
		<script src='https://www.google.com/recaptcha/api.js'></script>
<style>

table {
    width: 100%;
    margin: 2em 0;
    border-collapse: collapse;
    word-break:normal;
}

td {
    padding: .5em;
    vertical-align: top;
    border: 1px solid #bbbbbb;
}

th {
    padding: .5em;
    text-align: left;
    border: 1px solid #bbbbbb;
    border-bottom: 3px solid #bbbbbb;
    background:#f4f7fa;
}

	
.table-scrollable {
	width: 100%;
	overflow-y: auto;
	margin: 0 0 1em;	
}

.table-scrollable::-webkit-scrollbar {
	-webkit-appearance: none;
	width: 14px;
	height: 14px;
}

.table-scrollable::-webkit-scrollbar-thumb {
	border-radius: 8px;
	border: 3px solid #fff;
	background-color: rgba(0, 0, 0, .3);
}

</style>
		
		
</head>

<body id="landing">
<!-- Header -->

<header id="header">


    <h1><a href="<?php echo $maindomain; ?>"><?php echo $servername; ?></a></h1>
    <nav id="nav">
        <ul>
			<li><a href="<?php echo $domain;?>">Startseite</a></li>
        </ul>
	</nav>	
</header>
<!-- One -->
<section class="wrapper style special">
    <header class="major">
        <h2><?php echo $servername; ?></h2>
    </header>	
    <div class="container">
        <div class="row">

			<div class="6u 12u$(medium)">
                <section class="box">
                    <h3>Spieler suchen</h3>
						<p></p>
                    <form id="login" action="search.php" method="post">
						<p>Spielername oder Rang: <input type="text" name="username" class="form-control" placeholder="Spielername oder Rang" required /></p>
						<p></p>
						<input type="submit" value="Spieler suchen" />
						<p></p>
					</form>
					

                </section>
				
			</div>
			<?php
			if(strpos($_POST['username'], '#') !== false){
				
				$searchrank = str_replace("#","",$_POST['username']);
				?>
							<div class="6u 12u$(medium)">
                <section class="box">
                    <h3>Bedwars Stats</h3>
				<?php
					
	$statement = $pdo->prepare("SELECT * FROM MBedwars_stats WHERE Rank = ?");
	$statement->execute(array($searchrank)); 
	$anzahl_user = $statement->rowCount();	
	if ($anzahl_user == "1") {
		
$statement = $pdo->prepare("SELECT * FROM MBedwars_stats WHERE Rank = ?");
$statement->execute(array($searchrank));   
while($row = $statement->fetch()) {
		$rank = $row['Rank'];
        $name = $row['Playername'];
		$uuid = $row['UUID'];
		if($name = "?"){
			$mcusername = MojangAPI::getUsername($uuid);
		} else {
			$mcusername = $name;
		}
        $kills = $row['Kills'];
        $deaths = $row['Deaths'];
        $wins = $row['Wins'];
        $games = $row['RoundsPlayed'];
        $beds = $row['BedsDestroyed'];
        $playtime = $row['PlayTime'];
}
	
	  ?>
										<h4>von <?php echo $mcusername;?></h4>
										
										<p><img src="https://minotar.net/helm/<?php echo $mcusername?>/50" class="img-responsive"></p>
										<p>Er ist zurzeit Platz <?php echo $rank;?>, Starke Leistung!</p>
					                                        
                                        <p>Kills: <?php echo $kills;?></p>
                                        <p>Tode: <?php echo $deaths;?></p>
                                        <p>Spiele gewonnen: <?php echo $wins;?></p>
                                        <p>Spiele gespielt: <?php echo $games;?></p>
                                        <p>Betten zerstört: <?php echo $beds;?></p>
										<p>Spielzeit: <?php echo $playtime;?></p>
										<?php
	  
	} else {
		?><h4>Es wurde kein Spieler mit dem Platz <?php echo $_POST['username'];?> gefunden.<p>
		<p>mh schade..</h4><?php
	}
	
	  
		?>
					</section>
				</div>
				<?php
			} else {?>
			<div class="6u 12u$(medium)">
                <section class="box">
                    <h3>Bedwars Stats</h3>
				<?php

    $name = htmlspecialchars($_POST['username']);
		$uuid = MojangAPI::getUuid($name);
		$fulluuid = MojangAPI::formatUuid($uuid);

	$statement = $pdo->prepare("SELECT * FROM MBedwars_stats WHERE UUID = ?");
	$statement->execute(array($fulluuid)); 
	$anzahl_user = $statement->rowCount();	
	if ($anzahl_user == "1") {
 
	#$sql = "SELECT * FROM MBedwars_stats WHERE UUID = ".$fulluuid.""
	#$sql = "SELECT * FROM MBedwars_stats WHERE UUID =  ' ".$fulluuid . " '  ";
	#$row = $pdo->query($sql)->fetch();
	$statement = $pdo->prepare("SELECT * FROM MBedwars_stats WHERE UUID = ?");
$statement->execute(array($fulluuid));   
while($row = $statement->fetch()) {
		
		$rank = $row['Rank'];
		echo $row['Rank'];
        $name = $row['Playername'];
		$uuid = $row['UUID'];
		if($name = "?"){
			$username = MojangAPI::getUsername($uuid);
		} else {
			$username = $name;
		}
        $kills = $row['Kills'];
        $deaths = $row['Deaths'];
        $wins = $row['Wins'];
        $games = $row['RoundsPlayed'];
        $beds = $row['BedsDestroyed'];
        $playtime = $row['PlayTime'];

}
	  ?>
										<h4>von <?php echo $username;?></h4>
										<p><img src="https://minotar.net/helm/<?php echo $username?>/50" class="img-responsive"></p>
										<p>Er ist zurzeit Platz <?php echo $rank;?>, Starke Leistung!</p>
					                                        
                                        <p>Kills: <?php echo $kills;?></p>
                                        <p>Tode: <?php echo $deaths;?></p>
                                        <p>Spiele gewonnen: <?php echo $wins;?></p>
                                        <p>Spiele gespielt: <?php echo $games;?></p>
                                        <p>Betten zerstört: <?php echo $beds;?></p>
										<p>Spielzeit: <?php echo $playtime;?></p>
										<?php
	  
	} else {
		?><h4>Der Spieler <?php echo $_POST['username'];?> wurde nicht gefunden, er hat anscheinend noch nie Bedwars gespielt. <p>
		<p>mh schade..</h4><?php
	}
	
	  
		?>
					</section>
				</div>
				<?php
			}
			?>

		</div>
	</section>
	
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
</body>
</html>
