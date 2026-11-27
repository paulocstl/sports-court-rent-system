<?php
if (!isset($_POST["nome"])) {
    header("Location: cadastro.php");
    exit;
}

$nome = trim($_POST["nome"]);
$cpf = trim($_POST["cpf"]);
$telefone = trim($_POST["telefone"]);
$email = trim($_POST["email"]);
$senha = $_POST["senha"];
$confirmar = $_POST["confirmar"];

if ($senha != $confirmar) {
    echo "As senhas não são iguais.";
    exit;
}

if ($nome == "" || $cpf == "" || $telefone == "" || $email == "") {
    echo "Preencha todos os campos.";
    exit;
}

if (strlen($cpf) != 11 || !ctype_digit($cpf)) {
    echo "O CPF deve conter 11 números, sem pontos ou traço.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Digite um e-mail válido.";
    exit;
}

if (strlen($senha) < 8) {
    echo "A senha deve ter pelo menos 8 caracteres.";
    exit;
}

if (mb_strlen($nome) < 3 || mb_strlen($nome) > 60 ||
    mb_strlen($telefone) > 20 || mb_strlen($email) > 100) {
    echo "Confira o tamanho dos campos preenchidos.";
    exit;
}

$senhaProtegida = password_hash($senha, PASSWORD_DEFAULT);
$status = "ativo";

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include("config/conexao.php");

    $sql = "INSERT INTO cliente
            (nome_completo, cpf, telefone, email, status_cadastro, senha)
            VALUES (?, ?, ?, ?, ?, ?)";

    $comando = $conn->prepare($sql);

    $comando->bind_param(
        "ssssss",
        $nome,
        $cpf,
        $telefone,
        $email,
        $status,
        $senhaProtegida
    );

    $comando->execute();

    $comando->close();
    $conn->close();

    header("Location: index.php?cadastro=sucesso");
    exit;

} catch (mysqli_sql_exception $erro) {
    if ($erro->getCode() == 1062) {
        echo "Já existe um cadastro com esse CPF ou e-mail.";
    } else {
        echo "Não foi possível realizar o cadastro. Confira a conexão com o banco.";
    }
};
?>