<?php
include_once("config/dados.php");
include("config/conexao.php");

$id = 0;

if (isset($_GET["id"])) {
    $idValidado = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    if ($idValidado !== false) {
        $id = $idValidado;
    }
}

$sql = "SELECT nome, descricao, tipo_piso, cobertura,
               capacidade, valor_hora
        FROM quadra
        WHERE id_quadra = ? AND status = 'ativa'";

$comando = $conn->prepare($sql);
$comando->bind_param("i", $id);
$comando->execute();
$comando->bind_result(
    $nome,
    $descricao,
    $piso,
    $cobertura,
    $capacidade,
    $preco
);

$quadra = null;

if ($comando->fetch()) {
    $imagem = "img/salao.jpg";
    $textoCobertura = "Descoberta";

    if ($piso == "areia") {
        $imagem = "img/areia.jpg";
    }

    if ($piso == "society" || $piso == "Grama sintética") {
        $imagem = "img/sintetico.jpeg";
    }

    if ($cobertura == 1) {
        $textoCobertura = "Coberta";
    }

    $quadra = [
        "nome" => $nome,
        "descricao" => $descricao,
        "piso" => $piso,
        "cobertura" => $textoCobertura,
        "capacidade" => $capacidade . " jogadores",
        "preco" => $preco,
        "imagem" => $imagem,
        "alt" => "Foto ilustrativa de quadra esportiva",
        "modalidade" => "Quadra esportiva"
    ];
}

$comando->close();

if ($quadra != null) {
    $sqlEsportes = "SELECT esporte.nome
                   FROM esporte
                   INNER JOIN quadra_esporte
                       ON esporte.id_esporte = quadra_esporte.id_esporte
                   WHERE quadra_esporte.id_quadra = ?
                       AND esporte.status = 'ativo'
                   ORDER BY esporte.nome";

    $comandoEsportes = $conn->prepare($sqlEsportes);
    $comandoEsportes->bind_param("i", $id);
    $comandoEsportes->execute();
    $comandoEsportes->bind_result($nomeEsporte);

    $modalidades = "";

    while ($comandoEsportes->fetch()) {
        if ($modalidades != "") {
            $modalidades = $modalidades . ", ";
        }

        $modalidades = $modalidades . $nomeEsporte;
    }

    if ($modalidades != "") {
        $quadra["modalidade"] = $modalidades;
    }

    $comandoEsportes->close();
}

$conn->close();

if ($quadra == null) {
    http_response_code(404);
    $titulo = "Quadra não encontrada";
} else {
    $titulo = $quadra["nome"];
}

include("estrutura/cabecalho.php");

if ($quadra == null) {
?>
    <h1>Quadra não encontrada</h1>
    <a href="quadras.php">Voltar às quadras</a>

<?php
} else {
?>
    <a class="voltar" href="quadras.php">← Todas as quadras</a>

    <p class="etiqueta">
        <?php echo e($quadra["modalidade"]); ?>
    </p>

    <h1><?php echo e($quadra["nome"]); ?></h1>

    <p class="introducao">
        <?php echo e($quadra["descricao"]); ?>
    </p>

    <div class="detalhes">
        <section>
            <img
                class="foto-quadra foto-detalhe"
                src="<?php echo e($quadra["imagem"]); ?>"
                alt="<?php echo e($quadra["alt"]); ?>"
                loading="lazy"
            >

            <h2>Conheça o espaço</h2>

            <dl>
                <div>
                    <dt>Piso</dt>
                    <dd><?php echo e($quadra["piso"]); ?></dd>
                </div>

                <div>
                    <dt>Cobertura</dt>
                    <dd><?php echo e($quadra["cobertura"]); ?></dd>
                </div>

                <div>
                    <dt>Capacidade</dt>
                    <dd><?php echo e($quadra["capacidade"]); ?></dd>
                </div>
            </dl>
        </section>

        <aside class="painel">
            <p class="etiqueta">VALOR POR HORA</p>

            <p class="valor">
                <?php echo preco($quadra["preco"]); ?>
            </p>

            <p>Confira a agenda para escolher o melhor momento para jogar.</p>

            <a class="botao"
               href="reserva.php?id=<?php echo $id; ?>">
                Consultar horários
            </a>

            <p class="ajuda">Foto ilustrativa. Informações consultadas no banco.</p>
        </aside>
    </div>

<?php
}

include("estrutura/rodape.php");
?>