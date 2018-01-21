<?php
$_SESSION['status'] = "OFF";
$_SESSION['msg'] = "";
$row="";
$GLOBALS['user_esistente']= false;

function log_in(){

 	  $us = $_POST['user'];
	  $pw = $_POST['passw'];

	 $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi");
	  $_SESSION['status'] = "ON";

	  mysql_select_db("test", $connessione) or die ("non seleziona");
	  $sql="SELECT ID FROM utenti WHERE username='".$us."' AND password='".$pw."'";
	  
	  $result = mysql_query($sql) or die ($sql);
	   if(mysql_num_rows($result)==1){ 

	  	while($row = mysql_fetch_array($result)) {
	    $_SESSION['msg'] = "<b><p style='color: blue;'> ID user: ".$row['ID']."</p></b>";
	    	
		}
		 mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
		 if($connessione == false){
	    		 $_SESSION['status'] = "OFF";
	    	}

	 }else{

	  	$_SESSION['msg'] = "<b><p style='color:red;'> Account non trovato, controllare i dati</p></b>";
	  }
}

function check_user(){
	  $us = $_POST['user'];
	  $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi");
	  mysql_select_db("test", $connessione) or die ("non seleziona");
	  $sql="SELECT ID FROM utenti WHERE username='".$us."'";
	  $result = mysql_query($sql) or die ($sql);
	  if(mysql_num_rows($result)==1){ 
	  while($row = mysql_fetch_array($result)) {
	    $GLOBALS['user_esistente']= false;
	     
		}
}else{

	  	$GLOBALS['user_esistente']= true;
	  }
mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
}


function sign_up(){

	$us = $_POST['user'];
    $pw = $_POST['passw'];
    check_user(); // richiamo la funzione per verificare se l'username esiste già 
if($GLOBALS['user_esistente'] == true){ // controllo se tutti i dati sono stati inseriti

	  $connessione = mysql_connect("localhost","root","") or die ("non riesco a connettermi");
	  $_SESSION['status'] = "ON";

	  mysql_select_db("test", $connessione) or die ("non seleziona");
	  mysql_query("INSERT INTO utenti (username, password) VALUES ('".$us."','".$pw."')") or die ("query fallita"); //eseguo query

	  $_SESSION['msg'] = "<b><p style='color:green;'> L'account è stato creato con successo</p></b>";
	  mysql_close($connessione) or die ("Non riesco a disconnettermi"); // chiudo la sessione 
	}else{

		if($GLOBALS['user_esistente'] == false){ // se il codice non parte devo capire se e' perche l'username è esistente
				 $_SESSION['msg'] = "<b><p style='color:red;'>L'username è gia esistente</p></b>"; // se l'username e' già stato preso
		}
	 
	}

} 


if(isset($_POST['send_data']))
   {
	 log_in();	  
	}
if(isset($_POST['register']))
   {
	 sign_up();	  
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
		<h1 align='center'> Log-in Database </h1>

<ul>
  <li><a href="home.html">Home</a></li>
  <li style="float:right;"><a class="active">Accedi</a></li>
  <li><a href="#">Pagina2</a></li>
  <li><a href="#">Pagina 3</a></li>
  </ul>

  <form align='center' name='data_user' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>' ><br><br>

<label><b>Username:</b></label><br>
<input style='' type='textbox' name='user' placeholder="Scegli un username" required><br>
<label><b>Email:</b></label><br>
<input style='' type='textbox' name='email' placeholder="La tua email" required><br>
<label><b>Password:</b></label><br>
<input style='' type='password' name="passw" placeholder="Scegli una password" required><br>
<label ><b>Ripeti password:</b></label><br>
<input style='' type='password' name="passw_conf" placeholder="Ripeti la password" required><br>
<input style='width: 150px;' type='submit' name='send_data' value='Accedi'><br>
<!-- <input style='width: 150px;' type='submit' name='register' value='Registrati'><br> -->

</form>
	</body>




</html>
