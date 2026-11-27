<?php
session_start();

if (!isset($_SESSION["id_cliente"])) {
    header("Location: login.php");
    exit;
}

include_once("config/dados.php");

$idCliente = $_SESSION["id_cliente"];
$reservas = [];
$erro = "";
$conn = null;

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include("config/conexao.php");

    $sql = "SELECT reserva.id_reserva, quadra.nome,
                   reserva.data_reserva, reserva.hora_inicial,
                   reserva.hora_final, reserva.status, reserva.valor_total
            FROM reserva
            INNER JOIN quadra
                ON reserva.id_quadra = quadra.id_quadra
            WHERE reserva.id_cliente = ?
            ORDER BY reserva.data_reserva DESC,
                     reserva.hora_inicial DESC, reserva.id_reserva DESC";

    $comando = $conn->prepare($sql);
    $comando->bind_param("i", $idCliente);
    $comando->execute();
    $comando->bind_result(
        $idReserva,
        $nomeQuadra,
        $dataReserva,
        $horaInicial,
        $horaFinal,
        $status,
        $valorTotal
    );

    while ($comando->fetch()) {
        $reservas[] = [
            "id" => $idReserva,
            "quadra" => $nomeQuadra,
            "data" => $dataReserva,
            "inicio" => $horaInicial,
            "fim" => $horaFinal,
            "status" => $status,
            "valor" => $valorTotal
        ];
    }

    $comando->close();
} catch (mysqli_sql_exception $falha) {
    $erro = "Não foi possível consultar suas reservas. Tente novamente.";
}

if ($conn != null) {
    $conn->close();
}

$titulo = "Minhas reservas";
include("estrutura/cabecalho.php");
?>

<h1>Minhas reservas</h1>

<?php if ($erro != "") { ?>
    <p class="mensagem" role="alert"><?php echo e($erro); ?></p>
<?php } elseif (count($reservas) == 0) { ?>
    <p>Você ainda não tem reservas.</p>
    <a class="botao" href="quadras.php">Escolher uma quadra</a>
<?php } else { ?>
    <div class="grade">
        <?php foreach ($reservas as $reserva) { ?>
            <article class="painel">
                <p class="etiqueta">Reserva nº <?php echo $reserva["id"]; ?></p>
                <h2><?php echo e($reserva["quadra"]); ?></h2>

                <p>
                    Data:
                    <?php echo date("d/m/Y", strtotime($reserva["data"])); ?>
                </p>

                <p>
                    Horário:
                    <?php echo date("H:i", strtotime($reserva["inicio"])); ?>
                    às <?php echo date("H:i", strtotime($reserva["fim"])); ?>
                </p>

                <p>Status: <?php echo e($reserva["status"]); ?></p>
                <p>Valor: <strong><?php echo preco($reserva["valor"]); ?></strong></p>
            </article>
        <?php } ?>
    </div>
<?php } ?>

<?php include("estrutura/rodape.php"); ?>