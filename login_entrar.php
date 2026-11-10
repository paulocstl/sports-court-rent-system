<?php
session_start();

if (!isset($_POST["email"], $_POST["senha"]) ||
    !is_string($_POST["email"]) || !is_string($_POST["senha"])) {
    header("Location: login.php");
    exit;
}

$email = trim($_POST["email"]);
$senha = $_POST["senha"];

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include("config/conexao.php");

    $sql = "SELECT id_cliente, nome_completo, senha
            FROM cliente
            WHERE email = ? AND status_cadastro = 'ativo'";

    $comando = $conn->prepare($sql);
    $comando->bind_param("s", $email);
    $comando->execute();
    $comando->bind_result($idCliente, $nomeCliente, $senhaProtegida);

    $encontrou = $comando->fetch();

    if ($encontrou && $senhaProtegida !== null &&
        password_verify($senha, $senhaProtegida)) {
        session_regenerate_id(true);
        $_SESSION["id_cliente"] = $idCliente;
        $_SESSION["nome_cliente"] = $nomeCliente;

        header("Location: index.php");
        exit;
    }

    $mensagemLogin = "E-mail ou senha incorretos.";

} catch (mysqli_sql_exception $erro) {
    echo 'Não foi possível entrar agora. <a href="login.php">Voltar ao login</a>';
}