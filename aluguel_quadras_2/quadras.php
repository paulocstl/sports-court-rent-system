<?php
$titulo = "Quadras";

include("config/conexao.php");
include("estrutura/cabecalho.php");

$modalidade = 0;

if (isset($_GET["modalidade"])) {
    $idValidado = filter_var(
        $_GET["modalidade"],
        FILTER_VALIDATE_INT
    );

    if ($idValidado !== false && $idValidado > 0) {
        $modalidade = $idValidado;
    }
}

$sqlEsportes = "SELECT id_esporte, nome
                FROM esporte
                WHERE status = 'ativo'
                ORDER BY nome";

$resultadoEsportes = $conn->query($sqlEsportes);

$sql = "SELECT DISTINCT quadra.id_quadra, quadra.nome,
               quadra.tipo_piso, quadra.cobertura,
               quadra.valor_hora
        FROM quadra
        LEFT JOIN quadra_esporte
            ON quadra.id_quadra = quadra_esporte.id_quadra
        WHERE quadra.status = 'ativa'";

if ($modalidade > 0) {
    $sql = $sql . " AND quadra_esporte.id_esporte = " . $modalidade;
}

$sql = $sql . " ORDER BY quadra.nome";

$resultado = $conn->query($sql);
?>

<p class="etiqueta">ENCONTRE SEU ESPAÇO</p>
<h1>Quadras disponíveis</h1>
<p class="introducao">
    Conheça as quadras e escolha o espaço do seu time.
</p>

<form class="filtro" action="quadras.php" method="get">
    <label for="modalidade">Modalidade</label>

    <select id="modalidade" name="modalidade"
        onchange="this.form.requestSubmit()">
        <option value="0">Todas as modalidades</option>

        <?php
        while ($esporte = $resultadoEsportes->fetch_assoc()) {
        ?>
            <option
                value="<?php echo $esporte["id_esporte"]; ?>"
                <?php
                if ($modalidade == $esporte["id_esporte"]) {
                    echo "selected";
                }
                ?>
            >
                <?php echo e($esporte["nome"]); ?>
            </option>
        <?php
        }
        ?>
    </select>

</form>

<div class="grade">
    <?php
    $encontradas = 0;

    while ($quadra = $resultado->fetch_assoc()) {
        $encontradas++;

        $imagem = "img/salao.jpg";
        $cobertura = "Descoberta";

        if ($quadra["tipo_piso"] == "areia") {
            $imagem = "img/areia.jpg";
        }

        if ($quadra["tipo_piso"] == "society" ||
            $quadra["tipo_piso"] == "Grama sintética") {
            $imagem = "img/sintetico.jpeg";
        }

        if ($quadra["cobertura"] == 1) {
            $cobertura = "Coberta";
        }
    ?>
        <article class="cartao">
            <img
                class="foto-quadra"
                src="<?php echo e($imagem); ?>"
                alt="Foto ilustrativa de quadra esportiva"
                loading="lazy"
            >

            <div class="cartao-corpo">
                <h2><?php echo e($quadra["nome"]); ?></h2>

                <p>
                    <?php echo e($quadra["tipo_piso"]); ?>
                    · <?php echo e($cobertura); ?>
                </p>

                <p>
                    <strong class="preco">
                        <?php echo preco($quadra["valor_hora"]); ?>
                    </strong>
                    / hora
                </p>

                <a
                    class="botao"
                    href="detalhes.php?id=<?php echo $quadra["id_quadra"]; ?>"
                >
                    Ver detalhes e horários
                </a>
            </div>
        </article>
    <?php
    }

    if ($encontradas == 0) {
    ?>
        <p>Nenhuma quadra disponível no momento.</p>
    <?php
    }
    ?>
</div>

<p class="ajuda">Fotos ilustrativas.</p>

<?php
$conn->close();
include("estrutura/rodape.php");
?>