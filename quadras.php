<?php
$titulo = "Quadras";
include("estrutura/cabecalho.php");

$modalidade = "";

if (isset($_GET["modalidade"])) {
    $modalidade = $_GET["modalidade"];
}
?>

<p class="etiqueta">ENCONTRE SEU ESPAÇO</p>
<h1>Quadras disponíveis</h1>
<p class="introducao">Conheça as quadras e escolha a modalidade do seu time.</p>

<form class="filtro" method="get">
    <label for="modalidade">Modalidade</label>

    <select id="modalidade" name="modalidade">
        <option value="">Todas as modalidades</option>

        <?php
        foreach ($quadras as $quadra) {
        ?>
            <option
                <?php
                if ($modalidade === $quadra["modalidade"]) {
                    echo "selected";
                }
                ?>
            ><?php echo e($quadra["modalidade"]); ?></option>
        <?php
        }
        ?>
    </select>

    <button>Filtrar quadras</button>
</form>

<div class="grade">
    <?php
    $encontradas = 0;

    foreach ($quadras as $id => $quadra) {
        if (empty($modalidade) || $modalidade === $quadra["modalidade"]) {
            $encontradas++;
    ?>
            <article class="cartao">
                <img
                    class="foto-quadra"
                    src="<?php echo e($quadra["imagem"]); ?>"
                    alt="<?php echo e($quadra["alt"]); ?>"
                    loading="lazy"
                >

                <div class="cartao-corpo">
                    <p class="etiqueta">
                        <?php echo e($quadra["modalidade"]); ?>
                    </p>

                    <h2><?php echo e($quadra["nome"]); ?></h2>

                    <p><?php echo e($quadra["piso"]); ?> · <?php echo e($quadra["cobertura"]); ?></p>

                    <p><strong class="preco"><?php echo preco($quadra["preco"]); ?></strong> / hora</p><a class="botao" href="detalhes.php?id=<?php echo $id; ?>">Ver detalhes e horários</a>
                </div>
            </article>
    <?php
        }
    }

    if ($encontradas == 0) {
    ?>
        <p>Nenhuma quadra encontrada. <a href="quadras.php">Ver todas as quadras</a>.</p>
    <?php
    }
    ?>
</div>

<?php
include("estrutura/rodape.php");
?>