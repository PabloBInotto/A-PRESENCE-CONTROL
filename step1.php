<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	

		
		<script language=javascript>
			window.document.write(new Date());
			
			function datadeci(){
			var d= new Date();
				document.getElementById('datadec').value= d.getFullYear()+"/"+d.getMonth()+"/"+d.getDate();
			}
		</script>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
 <!--Google Font and style definitions -->
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold">
	<link rel="stylesheet" href="css/style.css">
	
	<!-- include the skins (change to dark if you like) -->
	<link rel="stylesheet" href="css/light/theme.css" id="themestyle">
<link rel="stylesheet" href="css/dark/theme.css" id="themestyle"> 
	

	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<link rel="stylesheet" href="css/ie.css">
	
	
	<!-- Apple iOS and Android stuff -->
	<meta name="apple-mobile-web-app-capable" content="no">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
	
	<!-- Apple iOS and Android stuff - don't remove! -->
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">
	
	<!-- Use Google CDN for jQuery and jQuery UI -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
	
	<!-- Loading JS Files this way is not recommended! Merge them but keep their order -->
	
	<!-- some basic functions -->
	<script src="js/functions.js"></script>
		
	<!-- all Third Party Plugins and Whitelabel Plugins -->
	<script src="js/plugins.js"></script>
	<script src="js/editor.js"></script>
	<script src="js/calendar.js"></script>
	<script src="js/flot.js"></script>
	<script src="js/elfinder.js"></script>
	<script src="js/datatables.js"></script>
	<script src="js/wl_Alert.js"></script>
	<script src="js/wl_Autocomplete.js"></script>
	<script src="js/wl_Breadcrumb.js"></script>
	<script src="js/wl_Calendar.js"></script>
	<script src="js/wl_Chart.js"></script>
	<script src="js/wl_Color.js"></script>
	<script src="js/wl_Date.js"></script>
	<script src="js/wl_Editor.js"></script>
	<script src="js/wl_File.js"></script>
	<script src="js/wl_Dialog.js"></script>
	<script src="js/wl_Fileexplorer.js"></script>
	<script src="js/wl_Form.js"></script>
	<script src="js/wl_Gallery.js"></script>
	<script src="js/wl_Multiselect.js"></script>
	<script src="js/wl_Number.js"></script>
	<script src="js/wl_Password.js"></script>
	<script src="js/wl_Slider.js"></script>
	<script src="js/wl_Store.js"></script>
	<script src="js/wl_Time.js"></script>
	<script src="js/wl_Valid.js"></script>
	<script src="js/wl_Widget.js"></script>
	
<!--configuration to overwrite settings -->
	<script src="js/config.js"></script>
		
<!--the script which handles all the access to plugins etc... -->
	<script src="js/script.js"></script>
	
</head>


	<body>

<div class="g12">	

<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'eesh';

// Create connection
$conn = @mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . @mysqli_connect_error());
}

  // Lista de tipos de arquivos permitidos
  $tiposPermitidos= array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png');
  // Tamanho mÃ¡ximo (em bytes)
  $tamanhoPermitido = 1024 * 500; // 500 Kb
  
    $foto = $_FILES['foto'];

if(empty($_POST['nome']) || empty($_POST['fone']) || empty($_POST['email']) || empty($_POST['dept']) || empty($_POST['turno']) || empty($_POST['div']) || empty($_POST['rfid']))
	
{
 echo "<h1>Algum campo ficou sem preencher!! </h1><br><a href='daily.php'><h1>Voltar</h1></a><br>";
     exit();

	
	 
}
else  
	

$div = $_POST['country'];

$arqName = $_FILES['foto']['name'];
$arqType = $_FILES['foto']['type'];
$arqSize = $_FILES['foto']['size'];
$arqTemp = $_FILES['foto']['tmp_name'];
$arqError = $_FILES['foto']['error'];

	if ($arqError == 0) {
        // Verifica o tipo de arquivo enviado
    if (array_search($arqType, $tiposPermitidos) === false) {
      echo '<h1>O tipo de arquivo enviado é inválido!</h1>';
    // Verifica o tamanho do arquivo enviado
    } else if ($arqSize > $tamanhoPermitido) {
      echo '<h1>O tamanho do arquivo enviado é maior que o limite!</h1>';
    // Não houveram erros, move o arquivo
    } else {
      $pasta = "fd/";
      // Pega a extensão do arquivo enviado
      $extensao = strtolower(end(explode('.', $arqName)));
      // Define o novo nome do arquivo usando um UNIX TIMESTAMP
      $nome = time() . '.' . $extensao;

      // Escapa os caracteres protegidos do MySQL (para o nome do usuário)
      $nomeMySQL = mysql_real_escape_string($_POST['Item']);

      $upload = move_uploaded_file($arqTemp, $pasta . $nome);



 if (isset($_POST["nome"]) && ($_POST["nome"] != "")&& isset($_POST["fone"]) && ($_POST["fone"] != "")&& isset($_POST["email"]) && ($_POST["email"] != "") && isset($_POST["dept"]) && ($_POST["dept"] != "") && isset($_POST["turno"]) && ($_POST["turno"] != "")&& isset($_POST["div"]) && ($_POST["div"] != "")&& isset($_POST["rfid"]) && ($_POST["rfid"] != "")&& isset($_FILES["foto"]) && ($_FILES["foto"] != ""))
			

$sql = "INSERT INTO event (nome, fone, email, dept, turno, divi, rfid, foto) VALUES ('".$_POST['nome']."' , '".$_POST['fone']."' , '".$_POST['email']."' , '".$_POST['dept']."' , '".$_POST['turno']."' , '".$_POST['div']."' , '".$_POST['rfid']."' , '".$nome."')";

if (@mysqli_query($conn, $sql)) {

	
    echo "<h1>Você inseriu um novo item para o " . $div ;
	
 //recebo o último id

echo " número: " . @mysqli_insert_id($conn) . "<br>";
echo "<meta HTTP-EQUIV='Refresh' CONTENT='2, URL=cadastro.php'>";



	
	
} 
else
	{
	echo "<h1>Não foi possível atualizar as notícia, tente novamente.</h1>";
	
    echo "Error: " . $sql . "<br>" . @mysql_error($conn);
		}
	}
	



	 echo "<a href='cadastro.php'><h1>Voltar</h1></a><br>";
     exit();
	
	
}

	 
     exit();

mysql_close($conn);




?>



 


	</body>
</html>	