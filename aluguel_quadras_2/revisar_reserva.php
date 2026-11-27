<?php
session_start();

if (!isset($_SESSION["id_cliente"])) {
    header("Location: login.php");
    exit;
}

include_once("config/dados.php");

$dados = $_GET;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dados = $_POST;
}

$id = 0;
$data = "";
$hora = "";

if (isset($dados["id"])) {
    $idValidado = filter_var($dados["id"], FILTER_VALIDATE_INT);

    if ($idValidado !== false && $idValidado > 0) {
        $id = $idValidado;
    }
}

if (isset($dados["data"]) && is_string($dados["data"])) {
    $data = $dados["data"];
}

if (isset($dados["hora"]) && is_string($dados["hora"])) {
    $hora = $dados["hora"];
}

$erro = "";
$nome = "";
$precoHora = 0;
$fim = 0;
$valor = 0;
$inicio = strtotime($data . " " . $hora);
$dataNumero = strtotime($data);

if ($dataNumero === false || date("Y-m-d", $dataNumero) != $data ||
    $inicio === false || date("Y-m-d H:i", $inicio) != $data . " " . $hora) {
    $erro = "Escolha uma data e um horário válidos na agenda.";
} elseif ($inicio <= strtotime(date("Y-m-d H:i:s"))) {
    $erro = "Esse horário já passou. Escolha outro na agenda.";
}

$conn = null;
$transacao = false;

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include("config/conexao.php");

    if ($erro == "" && $_SERVER["REQUEST_METHOD"] == "POST") {
        $conn->begin_transaction();
        $transacao = true;
    }

    if ($erro == "") {
        $sql = "SELECT nome, valor_hora
                FROM quadra
                WHERE id_quadra = ? AND status = 'ativa'";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $sql = $sql . " FOR UPDATE";
        }

        $comando = $conn->prepare($sql);
        $comando->bind_param("i", $id);
        $comando->execute();
        $comando->bind_result($nome, $precoHora);

        if (!$comando->fetch()) {
            $erro = "Quadra não encontrada ou indisponível.";
        }

        $comando->close();
    }

    if ($erro == "") {
        $dias = [
            "domingo", "segunda-feira", "terca-feira",
            "quarta-feira", "quinta-feira", "sexta-feira", "sabado"
        ];

        $diaSemana = $dias[date("w", $dataNumero)];

        $sql = "SELECT hora_abertura, hora_encerramento, intervalo_reservas
                FROM horario_funcionamento
                WHERE id_quadra = ? AND dia_semana = ?";

        $comando = $conn->prepare($sql);
        $comando->bind_param("is", $id, $diaSemana);
        $comando->execute();
        $comando->bind_result($abertura, $encerramento, $intervalo);

        $horarioValido = false;

        while ($comando->fetch()) {
            $primeiro = strtotime($data . " " . $abertura);
            $limite = strtotime($data . " " . $encerramento);
            $duracao = (int) $intervalo;

            if ($duracao > 0) {
                $fimCalculado = strtotime("+" . $duracao . " minutes", $inicio);

                if ($inicio >= $primeiro && $fimCalculado <= $limite &&
                    ($inicio - $primeiro) % ($duracao * 60) == 0) {
                    $horarioValido = true;
                    $fim = $fimCalculado;
                    $valor = $precoHora * $duracao / 60;
                }
            }
        }

        $comando->close();

        if (!$horarioValido) {
            $erro = "Esse horário não faz parte da agenda da quadra.";
        }
    }

    if ($erro == "") {
        $horaInicial = date("H:i:s", $inicio);
        $horaFinal = date("H:i:s", $fim);

        $sql = "SELECT COUNT(*)
                FROM reserva
                WHERE id_quadra = ? AND data_reserva = ?
                    AND status <> 'cancelada'
                    AND hora_inicial < ? AND hora_final > ?";

        $comando = $conn->prepare($sql);
        $comando->bind_param("isss", $id, $data, $horaFinal, $horaInicial);
        $comando->execute();
        $comando->bind_result($ocupadas);
        $comando->fetch();
        $comando->close();

        if ($ocupadas > 0) {
            $erro = "Esse horário já foi reservado. Escolha outro na agenda.";
        }
    }


    if ($erro == "" && $_SERVER["REQUEST_METHOD"] == "POST") {
        $idCliente = $_SESSION["id_cliente"];

        $sql = "SELECT id_cliente
                FROM cliente
                WHERE id_cliente = ? AND status_cadastro = 'ativo'
                FOR UPDATE";

        $comando = $conn->prepare($sql);
        $comando->bind_param("i", $idCliente);
        $comando->execute();
        $comando->bind_result($clienteAtivo);

        if (!$comando->fetch()) {
            $erro = "Sua conta está indisponível. Entre novamente.";
        }

        $comando->close();
    }

    if ($erro == "" && $_SERVER["REQUEST_METHOD"] == "POST") {
        $registro = date("Y-m-d H:i:s");
        $status = "confirmada";

        $sql = "INSERT INTO reserva
                (id_cliente, id_quadra, data_reserva, hora_inicial,
                 hora_final, data_hora_registro, status, valor_total)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $comando = $conn->prepare($sql);
        $comando->bind_param(
            "iisssssd",
            $idCliente,
            $id,
            $data,
            $horaInicial,
            $horaFinal,
            $registro,
            $status,
            $valor
        );
        $comando->execute();
        $comando->close();

        $conn->commit();
        $transacao = false;
        $conn->close();

        $_SESSION["reserva_confirmada"] = true;

        header("Location: reserva.php?id=" . $id . "&data=" . $data);
        exit;
    }

    if ($transacao) {
        $conn->rollback();
        $transacao = false;
    }
} catch (mysqli_sql_exception $falha) {
    if ($transacao) {
        $conn->rollback();
    }

    $erro = "Não foi possível concluir a consulta ou a reserva. Volte à agenda e tente novamente.";
}

if ($conn != null) {
    $conn->close();
}
$titulo = "Revisar reserva";
include("estrutura/cabecalho.php");
?>

<h1>Revisar reserva</h1>

<?php if ($erro != "") { ?>
    <p class="mensagem" role="alert"><?php echo e($erro); ?></p>
<?php } else { ?>
    <section class="painel">
        <h2><?php echo e($nome); ?></h2>
        <p>Data: <?php echo date("d/m/Y", $dataNumero); ?></p>
        <p>
            Horário: <?php echo date("H:i", $inicio); ?>
            às <?php echo date("H:i", $fim); ?>
        </p>
        <p>Duração: <?php echo ($fim - $inicio) / 60; ?> minutos</p>
        <p>Valor total: <strong><?php echo preco($valor); ?></strong></p>

        <form action="revisar_reserva.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="data" value="<?php echo e($data); ?>">
            <input type="hidden" name="hora" value="<?php echo e($hora); ?>">
            <button type="submit">Confirmar reserva</button>
        </form>
    </section>
<?php } ?>

<a class="voltar"
   href="reserva.php?id=<?php echo $id; ?>&amp;data=<?php echo e($data); ?>">
    ← Voltar à agenda
</a>

<?php include("estrutura/rodape.php"); ?>
