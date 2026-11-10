<?php
include_once("config/dados.php");

include("config/conexao.php");

$id = 0;

if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
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

$dataExemplo = "30/10/2026";
$titulo = "Consulta de horários";

include("estrutura/cabecalho.php");
?>

<form class="filtro" action="reserva.php" method="get">
    <label for="quadra">Quadra</label>

    <select id="quadra" name="id" required>
        <option value="">Escolha uma quadra</option>

        <?php foreach ($quadrasAgenda as $idQuadra => $item) { ?>
            <option value="<?php echo $idQuadra; ?>"
                <?php if ($id == $idQuadra) { echo "selected"; } ?>>
                <?php echo e($item["nome"]); ?>
            </option>
        <?php } ?>
    </select>

    <button type="submit">Consultar quadra</button>
</form>

<?php
if ($quadra == null) {
?>
    <h1>Escolha uma quadra</h1>
    <p>Selecione uma quadra para consultar sua agenda.</p>
    <a class="botao" href="quadras.php">Ver quadras</a>

<?php
} else {
?>
    <a class="voltar" href="detalhes.php?id=<?php echo $id; ?>">← Detalhes da quadra</a>

    <p class="etiqueta">AGENDA DA QUADRA</p>
    <h1>Consulta de horários</h1>

    <p class="introducao"><?php echo e($quadra["nome"]); ?> · <?php echo preco($quadra["valor_hora"]); ?> / hora</p>

    <h2>Agenda de <?php echo $dataExemplo; ?></h2>
    <p>Partidas de 1 hora · funcionamento das 08h às 22h.</p>

    <div class="horarios">
        <?php
        for ($hora = 8; $hora < 22; $hora++) {
        ?>
            <div class="horario indisponivel">
                <strong><?php echo sprintf("%02d:00 – %02d:00", $hora, $hora + 1); ?></strong>
                <span>Ocupado</span>
            </div>
        <?php
        }
        ?>
    </div>

    <p>Não há horários disponíveis neste dia.</p>

<?php
}

include("estrutura/rodape.php");
?>