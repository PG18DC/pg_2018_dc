<?php
session_start();
$_SESSION['status'] = ""; // altra variabile di debug
$_SESSION['msg'] = ""; // variabile di debug per visualizzare messaggi o risultati
$row="";
$GLOBALS['user_esistente']= false;
$_SESSION['registrato'];

function check_user(){ // funzione per verificare l'esistenza del username o meno 
  $us = $_POST['user'];

  $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi");
  mysql_select_db("test", $connessione) or die ("non seleziona");
  $sql="SELECT ID FROM utenti WHERE username='".$us."'";
  $result = mysql_query($sql) or die ($sql);

  if(mysql_num_rows($result)==1){ //

  while($row = mysql_fetch_row($result)) { // si potrebbe usare anche fetch_array, ma adesso non mi serve

    	$GLOBALS['user_esistente']= false;
     
	}

}else{

  	$GLOBALS['user_esistente']= true;
  }
mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
}


function sign_up(){  // funzione per la registrazione

$_SESSION['us'] = $_POST['user'];
$pw = $_POST['passw'];
$_SESSION['email'] = $_POST['email'];
$pw_conf = $_POST['passw_conf'];
$token= md5(rand(1,999)); // creazione token in formato md5
$em_c = false; // variabile di appoggio per sapere se l'email è stata scritta correttamente o meno

check_user(); // richiamo la funzione per verificare se l'username esiste già 


if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_SESSION['email'])){ // verifica corretta scrittura del formato dell'email
	$em_c = false;
	}else
	{
	$em_c = true;
	}


if(($GLOBALS['user_esistente'] == true) && ($pw == $pw_conf) && ($em_c == true)){ // controllo se tutti i dati sono stati inseriti e le condizioni siano soddisfatte
 // $pw= password_hash($pw, PASSWORD_BCRYPT); --> da mettere nel dimentica password come generazione casusale di una passw
  $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi");
  $_SESSION['status'] = "ON";

  mysql_select_db("test", $connessione) or die ("non seleziona"); // mi connetto al database
  mysql_query("INSERT INTO utenti (username, password, email, token) VALUES ('".$_SESSION['us']."','".$pw."','".$_SESSION['email']."','".$token."')") or die ("query fallita"); //eseguo query
  $_SESSION['msg'] = "<b><p style='color:green;'> L'account è stato creato con successo, confermare l'email</p></b>";  // account creato con successo 
 




  $_SESSION['status'] = $_SESSION['us'];
  mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
  $_SESSION['registrato'] = true;


}else{

	if($em_c == false){ // evventuale messaggio di errore per l'email

		$_SESSION['msg'] = "<b><p style='color:red;'>Inserire un indirizzo email valido</p></b>" ; // messaggio di errore 
		  $_SESSION['registrato'] = false;
	}elseif($GLOBALS['user_esistente'] = false){ // se il codice non parte devo capire se e' perche l'username è esistente o altro...
$_SESSION['registrato'] = false;
			 $_SESSION['msg'] = "<b><p style='color:red;'>L'username è gia esistente </p></b>" ; // se l'username e' già stato preso
	}elseif($pw != $pw_conf){
		$_SESSION['registrato'] = false;
 		$_SESSION['msg'] = "<b><p style='color:red;'>Le password non corrispondono</p></b>";
	}

	
 
}

} 

if(isset($_POST['register']))
{
 sign_up();	
 if($_SESSION['registrato'] == true){

   header('location: email_confirm.php'); 

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

<ul>
<li><a href="home.html">Home</a></li>
<li style="float:right;"><a class="active">Accedi</a></li>
<li><a href="#">Pagina2</a></li>
<li><a href="#">Pagina 3</a></li>
</ul>

<form align='center' name='data_user' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' ><br><br>
<div class="fm1">
<label><b>Username:</b></label><br>
<input style='' type='textbox' name='user' placeholder='Scegli un username' required><br>
<label><b>Email:</b></label><br>
<input style='' type='textbox' name='email' placeholder='La tua email' required><br>

<label><b>Password:</b></label><br>
<div class='fm2'>
<input id='passw_1' style='' type='password' name='passw' placeholder="Scegli una password" required>
<input type='button' id='showme' class='showhi' name='buttshow' value='show'></button><br>
</div>

<label ><b>Ripeti password:</b></label><br>
<input id='passw_c' style='' type='password' name='passw_conf' placeholder="Ripeti la password" required><br>
<input style='width: 150px;' type='submit' name='register' value='Registrati'><br>

<a align='center'><?php echo  $_SESSION['msg'];//variabile messaggio per DEBUG?></a> 
</div>
</form>

<!-- script per la visualizzazione della password o meno.. -->
<script>  
	
var Button = document.getElementById('showme');
var	text = document.getElementById('passw_1')
var	text_c = document.getElementById('passw_c')
var enabled= false;
	Button.onclick= function (){
		if(enabled== false){
			text.setAttribute('type','textbox');
			text_c.setAttribute('type','textbox');
			Button.setAttribute('value', 'hide')
			enabled= true
		}else{
	text.setAttribute('type','password');
	text_c.setAttribute('type','password');
	Button.setAttribute('value', 'show')
			enabled = false;
		}
	}

</script>

</body>




</html>





