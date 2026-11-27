<?php
include_once("config/dados.php");

$id = 0;

if (isset($_GET["id"])) {
    $idValidado = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    if ($idValidado !== false) {
        $id = $idValidado;
    }
}

$quadra = null;

if (isset($quadras[$id])) {
    $quadra = $quadras[$id];
}

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

            <p class="ajuda">Valores e informações de exemplo.</p>
        </aside>
    </div>

<?php
}

include("estrutura/rodape.php");
?>