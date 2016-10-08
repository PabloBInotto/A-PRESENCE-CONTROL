<!doctype html>
<html lang="en-us">
<head>
<SCRIPT LANGUAGE="JavaScript">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js">
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js">
</script>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <title>Cadastro de Brigadistas</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold">
 <link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/light/theme.css" id="themestyle">
 <meta name="apple-mobile-web-app-capable" content="no">
 <meta name="apple-mobile-web-app-status-bar-style" content="black">
 <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">
 <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/jquery-ui.min.js"></script>
</head>
<body>
<header>
 <div id="logo">
 <a href="dashboard.html"></a>
 </div>
 <div id="header">
 <ul id="searchboxresult">
 </ul>
 </div>
 <div id="header">
 <ul id="headernav">
 <li>
 <ul>
 <?php
$host = "servidor";
$db = "sua_base_de_dados";
$user = "root";
$pass = "";
$con = mysql_connect($host, $user, $pass) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($db, $con);
$query = sprintf("SELECT Qty FROM event WHERE divi = 'M' ");
$dados = mysql_query($query, $con) or die(mysql_error());
$total0 = mysql_num_rows($dados);
$query = sprintf("SELECT Qty FROM event WHERE divi = 'C' ");
$dados = mysql_query($query, $con) or die(mysql_error());
$total1 = mysql_num_rows($dados);
$query = sprintf("SELECT Qty FROM event WHERE divi = 'F' ");
$dados = mysql_query($query, $con) or die(mysql_error());
$total2 = mysql_num_rows($dados);
 
?>
 <li><a href="dashboard.php?div=M">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Predio 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><span><?=$total0?> Presentes</span></li>
 <li><a href="dashboard.php?div=F">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Predio 2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><span><?=$total2?> Presentes</span></li>
 <li><a href="dashboard.php?div=C">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Predio 3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a><span><?=$total1?> Presentes</span></li>
 </ul>
 </li>
 </ul>
 <div>
 <h3>Controle de presença</h3>
 </div>
 </div> 
 </header>
<form action="step1.php" method="post" enctype="multipart/form-data">
<div class="g3">
Nome: <input name="nome" class="element text medium" type="text" maxlength="255" value=""/>
</div>
<div class="g3">
Fone: <input name="fone" class="element text medium" type="text" maxlength="255" value=""/>
</div>
<div class="g3">
Email: <input name="email" class="element text medium" type="text" maxlength="255" value=""/>
</div>
<div class="g3">
 Departamento<br>
  
 <select class="element select medium" id="element_1" name="dept" data-errortext="This is mandatory!" required> 
 <option value="" selected="selected"></option>
 <option value="RH" >RH</option> 
 <option value="ESTOQ" >ESTOQ</option> 
 <option value="PROD" >PROD</option> 
 </select> 
 </div> 
 <div class="g3">
 Turno
 <br>
 <select class="element select medium" name="turno" data-errortext="This is mandatory!" required> 
 <option value="" selected="selected"></option>
<option value="P" >Primeiro</option>
<option value="S" >Segundo</option>
<option value="T" >Terceiro</option>
 </select>
 </div>
 <div class="g3">
 Predio<br>
 <select class="element select medium" name="div" data-errortext="This is mandatory!" required> 
 <option value="" selected="selected"></option>
 <option value="C">P1</option> 
 <option value="M">P2</option>
 </select>
 </div>
 <div class="g3">
 RFID: <input name="rfid" class="element text medium" type="text" maxlength="255" value=""/>
 </div>
 <div class="g3">
 Foto de exibição:<br />
<input type="file" name="foto" id="txFoto" data-errortext="This is mandatory!" required />
 </div>
 <div class="g3">
 <input type="submit" name="submit" value="Cadastrar" />
 </div>
</form>
 <hr>
 <div class="g12">
<table class="datatable">
 <thead>
 <tr>
 <th >Nome</th>
 <th >Departamento</th>
 <th >Turno</th>
 <th >Foto</th> 
 </tr>
 </thead>
 <tbody>
<?php
$conexao = mysql_connect("servidor","root","","eesh"); // Mapeando o caminho do banco de dados
if (!$conexao) // Verificando se existe conexão com o caminho mapeado
{
die('Erro ao conectar: ' . mysql_error()); // Caso o caminho esteja errado, o usuário ou a senha esteja errado, irá mostrar esta mensagem
}
mysql_select_db("eesh", $conexao); // Selecionando o banco de dados
$resultado = mysql_query("SELECT * FROM event ORDER BY `nome` DESC"); // Há variável $resultado faz uma consulta em nossa tabela selecionando todos os registros de todos os campos
while($link = mysql_fetch_array($resultado)) //Já a instrução while faz um loop entre todos os registros e armazena seus valores na variável $linha
{ 
//Inicia o loop
?>
 
<?php
echo "<tr class=\"gradeR\">";
echo "<td>" . $link['nome'] . "</td>";
echo "<td>" . $link['dept'] . "</td>";
echo "<td>" . $link['turno'] . "</td>";
echo "<td><img src='fd/".$link['foto']."' alt='Foto do brigadista' style='width:304px;height:228px;'></td>";
echo "</tr>";
} // Retorna para o início do loop caso existam mais registros a serem mostrados
?>
 </tbody>
 </table>
 </div>
<footer>Seu web site</footer>
</body>
</html>