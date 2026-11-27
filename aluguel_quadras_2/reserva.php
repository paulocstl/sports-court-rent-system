<?php
include_once("config/dados.php");
include("config/conexao.php");

$id = 0;

if (isset($_GET["id"])) {
    $idValidado = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    if ($idValidado !== false && $idValidado > 0) {
        $id = $idValidado;
    }
}

$hoje = date("Y-m-d");
$data = $hoje;
$erroData = "";

if (isset($_GET["data"])) {
    if (is_string($_GET["data"])) {
        $data = $_GET["data"];
    } else {
        $data = "";
    }
}

$dataNumero = strtotime($data);

if ($dataNumero === false || date("Y-m-d", $dataNumero) != $data) {
    $erroData = "Escolha uma data válida.";
} elseif ($data < $hoje) {
    $erroData = "Escolha a data de hoje ou uma data futura.";
}

$sql = "SELECT id_quadra, nome, valor_hora
        FROM quadra
        WHERE status = 'ativa'
        ORDER BY nome";

$resultado = $conn->query($sql);
$quadrasAgenda = [];

while ($linha = $resultado->fetch_assoc()) {
    $quadrasAgenda[$linha["id_quadra"]] = $linha;
}

$quadra = null;

if (isset($quadrasAgenda[$id])) {
    $quadra = $quadrasAgenda[$id];
}

$horarios = [];
$reservas = [];

if ($quadra != null && $erroData == "") {
    $dias = [
        "domingo", "segunda-feira", "terca-feira",
        "quarta-feira", "quinta-feira", "sexta-feira", "sabado"
    ];

    $diaSemana = $dias[date("w", $dataNumero)];

    $sql = "SELECT hora_abertura, hora_encerramento, intervalo_reservas
            FROM horario_funcionamento
            WHERE id_quadra = ? AND dia_semana = ?
            ORDER BY hora_abertura";

    $comando = $conn->prepare($sql);
    $comando->bind_param("is", $id, $diaSemana);
    $comando->execute();
    $comando->bind_result($abertura, $encerramento, $intervalo);

    while ($comando->fetch()) {
        $horarios[] = [
            "abertura" => $abertura,
            "encerramento" => $encerramento,
            "intervalo" => $intervalo
        ];
    }

    $comando->close();

    $sql = "SELECT hora_inicial, hora_final
            FROM reserva
            WHERE id_quadra = ? AND data_reserva = ?
                AND status <> 'cancelada'";

    $comando = $conn->prepare($sql);
    $comando->bind_param("is", $id, $data);
    $comando->execute();
    $comando->bind_result($inicioReserva, $fimReserva);

    while ($comando->fetch()) {
        $reservas[] = [
            "inicio" => strtotime($data . " " . $inicioReserva),
            "fim" => strtotime($data . " " . $fimReserva)
        ];
    }

    $comando->close();
}

$conn->close();
$titulo = "Consulta de horários";
include("estrutura/cabecalho.php");
?>

<p class="etiqueta">AGENDA DA QUADRA</p>
<h1>Consulta de horários</h1>

<?php if (isset($_SESSION["reserva_confirmada"])) { ?>
    <p role="status">Reserva confirmada com sucesso!</p>
    <?php unset($_SESSION["reserva_confirmada"]); ?>
<?php } ?>

<form class="filtro" action="reserva.php" method="get">
    <label for="quadra">Quadra</label>
    <select id="quadra" name="id" required
        onchange="this.form.requestSubmit()">
        <option value="">Escolha uma quadra</option>
        <?php foreach ($quadrasAgenda as $idQuadra => $item) { ?>
            <option value="<?php echo $idQuadra; ?>"
                <?php if ($id == $idQuadra) { echo "selected"; } ?>>
                <?php echo e($item["nome"]); ?>
            </option>
        <?php } ?>
    </select>

    <label for="data">Data</label>
    <input type="date" id="data" name="data"
       value="<?php echo e($data); ?>"
       min="<?php echo $hoje; ?>" required
       onchange="this.form.requestSubmit()">

</form>

<?php if ($erroData != "") { ?>
    <p class="mensagem" role="alert"><?php echo e($erroData); ?></p>
<?php } elseif ($quadra == null) { ?>
    <p>Escolha uma quadra para consultar sua agenda.</p>
<?php } else { ?>
    <a class="voltar" href="detalhes.php?id=<?php echo $id; ?>">
        ← Detalhes da quadra
    </a>

    <p class="introducao">
        <?php echo e($quadra["nome"]); ?> ·
        <?php echo preco($quadra["valor_hora"]); ?> / hora
    </p>
    <h2>Agenda de <?php echo date("d/m/Y", $dataNumero); ?></h2>

    <?php if (count($horarios) == 0) { ?>
        <p>A quadra está fechada neste dia.</p>
    <?php } else { ?>
        <div class="horarios">
            <?php
            $agora = strtotime(date("Y-m-d H:i:s"));
            
            foreach ($horarios as $funcionamento) {
                $inicio = strtotime($data . " " . $funcionamento["abertura"]);
                $limite = strtotime($data . " " . $funcionamento["encerramento"]);
                $duracao = (int) $funcionamento["intervalo"];

                if ($duracao > 0) {
                    $fim = strtotime("+" . $duracao . " minutes", $inicio);

                    while ($fim <= $limite) {
                        $situacao = "Disponível";
                        $classe = "horario";

                        foreach ($reservas as $reserva) {
                            if ($inicio < $reserva["fim"] && $fim > $reserva["inicio"]) {
                                $situacao = "Ocupado";
                                $classe = "horario indisponivel";
                            }
                        }

                        if ($inicio <= $agora) {
                            $situacao = "Horário encerrado";
                            $classe = "horario indisponivel";
                        }
            ?>
                        <div class="<?php echo $classe; ?>">
                            <strong>
                                <?php echo date("H:i", $inicio); ?> –
                                <?php echo date("H:i", $fim); ?>
                            </strong>
                            <span><?php echo $situacao; ?></span>
                            <?php if ($situacao == "Disponível") { ?>
                                <form action="revisar_reserva.php" method="get">
                                    <input type="hidden" name="id"
                                        value="<?php echo $id; ?>">

                                    <input type="hidden" name="data"
                                        value="<?php echo e($data); ?>">

                                    <input type="hidden" name="hora"
                                        value="<?php echo date("H:i", $inicio); ?>">

                                    <button type="submit">Escolher horário</button>
                                </form>
                            <?php } ?>
                        </div>
            <?php
                        $inicio = $fim;
                        $fim = strtotime("+" . $duracao . " minutes", $inicio);
                    }
                }
            }
            ?>
        </div>
    <?php } ?>
<?php } ?>

<?php include("estrutura/rodape.php"); ?>