<?php
session_start();

// Conecta ao banco de dados MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "posto";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Falha na conexão com o banco de dados: " . mysqli_connect_error());
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifica se o nome de usuário e a senha foram fornecidos
    if (isset($_POST['name']) && isset($_POST['password'])) {

        // Obtém o nome de usuário e a senha do formulário
        $nome = $_POST['nome'];
        $password = $_POST['password'];

        // Consulta o banco de dados para encontrar o usuário com o nome de usuário fornecido
        $sql = "SELECT * FROM clientes WHERE name='$nome'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Verifica a senha fornecida em relação à senha armazenada no banco de dados
            if (password_verify($password, $row['password'])) {

                // Define variáveis de sessão para indicar login bem-sucedido
                $_SESSION['loggedin'] = true;
                $_SESSION['nome'] = $nome;

                // Redireciona para a página inicial ou painel de controle
                header('Location: menu.php');
                exit;
            }
        }

    }

    // Se o login falhar, exibe mensagem de erro
    $error_message = 'Nome de usuário ou senha inválidos.';
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post" action="menu.php">
        <label for="nome">Nome de usuário:</label>
        <input type="text" id="nome" name="nome"><br><br>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
        <a href="cadastro.php">Cadastre-se</a>
    </form>
    
</body>
</html>
