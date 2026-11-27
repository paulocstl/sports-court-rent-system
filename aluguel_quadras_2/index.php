<?php
$titulo = "Seu próximo jogo";
include("estrutura/cabecalho.php");
?>

<?php
if (isset($_GET["cadastro"]) && $_GET["cadastro"] == "sucesso") {
?>
    <p class="ajuda" role="status">
        Cadastro realizado com sucesso!
    </p>
<?php
}
?>

<section class="hero">
    <div>
        <p class="etiqueta">ALUGUEL DE QUADRAS</p>
        <h1>Encontre sua quadra</h1>
        <p>Encontre o espaço para a sua modalidade e consulte os horários para reunir a galera.</p><a class="botao" href="quadras.php">Explorar quadras <span aria-hidden="true">↗</span></a>
    </div>
    <img class="foto-inicio" src="img/sintetico.jpeg" alt="Quadra coberta de grama sintética">
</section>

<section>
    <p class="etiqueta">COMBINE A PRÓXIMA PARTIDA</p>
    <h2>Como funciona</h2>
    <div class="passos">
        <article><b>01</b>
            <h3>Encontre sua quadra</h3>
            <p>Compare modalidades, estruturas e valores por hora.</p>
        </article>
        <article><b>02</b>
            <h3>Confira os detalhes</h3>
            <p>Veja o piso, a cobertura e a capacidade de cada espaço.</p>
        </article>
        <article><b>03</b>
            <h3>Consulte os horários</h3>
            <p>Veja os horários de um dia na agenda demonstrativa.</p>
        </article>
    </div>
</section>

<?php
include("estrutura/rodape.php");
?>