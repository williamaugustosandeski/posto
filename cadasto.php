<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/cadastro.css">
</head>

  <form method="post" action="cadastro.php">
  <label for="nome">Nome:</label>
  <input type="text" id="nome" name="nome">
  <label for="email">E-mail:</label>
  <input type="email" id="email" name="email">
  <label for="senha">Senha:</label>
  <input type="password" id="senha" name="senha">
  <input type="submit" value="Cadastrar">
  </form>
</body>
</html>
<?php
// Conecta ao banco de dados MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "posto";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
  
    // Verifica se o e-mail já está cadastrado no banco de dados
    $sql = "SELECT * FROM clientes WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
  
    // Se a consulta retornar algum resultado, significa que o e-mail já está cadastrado
    if (mysqli_num_rows($result) > 0) {
      echo "O e-mail já está cadastrado no sistema.";
    } else {
      // Insere os dados do novo usuário no banco de dados
      $sql = "INSERT INTO clientes (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
      mysqli_query($conn, $sql);
      echo "Cadastro realizado com sucesso!";
      header("Location: menu.php");
      exit();
    }
  }
  ?>
