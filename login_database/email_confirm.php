<?php
session_start();

function tok(){

	 $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi"); // per la con.
	  $_SESSION['status'] = "ON";

	  mysql_select_db("test", $connessione) or die ("non seleziona"); // seleziona database e si connette 
	 // $pw= password_hash($pw, PASSWORD_BCRYPT); --> da mettere nel dimentica password come generazione casusale di una passw

$id="SELECT ID FROM utenti WHERE username ='".$_SESSION['us']."'"; // query
	  
	  $result = mysql_query($id) or die ($id);
	   if(mysql_num_rows($result)==1){ 


	  	while($row = mysql_fetch_array($result)) {  
	    $_SESSION['id'] = $row['ID'];
	    	
		}
	  }


	  $token="SELECT token FROM utenti WHERE ID ='".$_SESSION['id']."'"; // query
	  
	  $result = mysql_query($token) or die ($token);
	   if(mysql_num_rows($result)==1){ 


	  	while($row = mysql_fetch_array($result)) {  
	    $_SESSION['token'] = $row['token'];
	    	
		}
		 mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
	     $_SESSION['status'] = "OFF";
	 }else{

	  	$_SESSION['msg'] = "<b><p style='color:red;'> Account non trovato, controllare i dati</p></b>";
	  }



}


tok(); //avvio funzione per ottenere il token 


function send_email(){

if(isset($_SESSION['token'])){

	$to = $_SESSION['email'];
	$subject = "";
	$message = $_SESSION['token'];
	 
	$from = "";
	$headers = "";
	$headers .= "Content-type: text/plain; charset=UTF-8" . "\r\n"; 
	 
	mail($to,"My subject",$message);
}


}


?>


<!DOCTYPE html>
<html>
<head>
	<title>Private area </title>

	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style/menu.css">
	<link rel="stylesheet" type="text/css" href="style/log_sign.css">

</head>
<body>


	
	<h1 align='center'> Log-in Database <?php echo $_SESSION['status']; ?></h1>
	<?php
echo $_SESSION['token']; echo $_SESSION['email'];?>
<ul>
<li><a href="home.html">Home</a></li>
<li style="float:right;"><a class="active">Accedi</a></li>
<li><a href="#">Pagina2</a></li>
<li><a href="#">Pagina 3</a></li>
</ul>


</body>




</html>


<!-- CREATE TABLE `test`.`utenti` 
( `ID` INT(20) NOT NULL AUTO_INCREMENT , 
`username` VARCHAR(20) NOT NULL , 
`password` VARCHAR(20) NOT NULL , 
`email` VARCHAR(20) NOT NULL , 
`token` VARCHAR(30) NOT NULL , 
`autenticato` INT(0) NOT NULL , 
PRIMARY KEY (`ID`)) ENGINE = InnoDB; -->