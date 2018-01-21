<?php
session_start(); 
$_SESSION['status']= null; //debug 
$_SESSION['msg'] = "";  // debug
$row="";

function log_in(){ // funzione per il login

 	  $us = $_POST['user']; // variabili locali
	  $pw = $_POST['passw'];

	 $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi"); // per la con.
	  $_SESSION['status'] = "ON";

	  mysql_select_db("test", $connessione) or die ("non seleziona"); // seleziona database e si connette 
	 // $pw= password_hash($pw, PASSWORD_BCRYPT); --> da mettere nel dimentica password come generazione casusale di una passw
	  $sql="SELECT ID FROM utenti WHERE username='".$us."' AND password='".$pw."'"; // query
	  
	  $result = mysql_query($sql) or die ($sql);
	   if(mysql_num_rows($result)==1){ 


	  	while($row = mysql_fetch_array($result)) {  
	    $_SESSION['msg'] = "<b><p style='color: blue;'> ID user: ".$row['ID']."</p></b>";
	    $_SESSION['id']  = $row['ID'];
	    	
		}
		 mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
	     $_SESSION['status'] = "OFF";
	 }else{

	  	$_SESSION['msg'] = "<b><p style='color:red;'> Account non trovato, controllare i dati</p></b>";
	  }
}



if(isset($_POST['send_data']))
   {
	 log_in();	  
	}



?>

<!DOCTYPE html>
<html>
	<head>
		<title>Private area </title>

		<meta charset="UTF-8">
		<link rel='stylesheet' type='text/css' href='style/menu.css'>
	<link rel='stylesheet' type='text/css' href='style/log_sign.css'>
	</head>
	<body>
	<h1 align='center'> Log-in Database || <?php echo $_SESSION['status']; ?></h1>

<ul>
  <li><a href='home.html'>Home</a></li>
  <li style='float:right;'><a class='active'>Accedi</a></li>
  <li><a href="#">Pagina2</a></li>
  <li><a href="#">Pagina 3</a></li>
  </ul>

  <form align='center' name='data_user' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' ><br><br>
<input style='' type='textbox' name='user' placeholder="Username" required><br>
<input style='' type='password' name="passw" placeholder="Password" required><br>
<input style='width: 150px;' type='submit' name='send_data' value='Accedi'><br>
<!-- <input style='width: 150px;' type='submit' name='register' value='Registrati'><br> -->
<a href="signup.php"> Se non possiedi un account, registrati </a>
<a align='center'><?php echo  $_SESSION['msg']; //variabile messaggio per DEBUGb    ?></a> 
</form>
	</body>




</html>
