<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("config/dados.php");

if (!isset($titulo)) {
    $titulo = "Início";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e($titulo); ?> | ArenaHub</title>

    <link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>
    <a class="pular" href="#conteudo">Pular para o conteúdo</a>

    <header>
        <div class="barra">
            <a class="marca" href="index.php">
                Arena<span>Hub</span>
                <small>RESERVA DE QUADRAS</small>
            </a>

            <nav aria-label="Navegação principal">
                <a href="index.php">Início</a>
                <a href="quadras.php">Quadras</a>

                <?php if (isset($_SESSION["id_cliente"])) { ?>
                    <span>Olá, <?php echo e($_SESSION["nome_cliente"]); ?></span>

                    <form action="sair.php" method="post">
                        <button type="submit">Sair</button>
                    </form>
                <?php } else { ?>
                    <a href="login.php">Entrar</a>
                    <a href="cadastro.php">Criar conta</a>
                <?php } ?>
            </nav>
        </div>
    </header>

    <main id="conteudo">