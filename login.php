<?php
$titulo = "Bom ter você de volta";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("login_entrar.php");
}

include("estrutura/cabecalho.php");
?>

<div class="auth">
    <section>
        <p class="etiqueta">LOGIN</p>
        <h1>Bom ter você de volta</h1>
        <p>Seu próximo encontro com o esporte começa aqui.</p>
    </section>

    <section class="painel">
        <h2>Entrar</h2>
            <?php if (isset($mensagemLogin)) { ?>
            <p class="mensagem" role="alert"><?php echo $mensagemLogin; ?></p>
            <?php } ?>
        <form action="login.php" method="post">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" autocomplete="email" maxlength="190" required>

            <label for="senha">Senha</label>
            <div class="senha">
                <input type="password" id="senha" name="senha" autocomplete="current-password" minlength="8" required aria-describedby="dica-senha">
                <button type="button" data-senha aria-controls="senha" aria-pressed="false">Mostrar</button>
            </div>

            <p id="dica-senha" class="ajuda">Use pelo menos 8 caracteres.</p>

            <button class="botao" type="submit">Entrar</button>
        </form>

        <p>Ainda não tem conta? <a href="cadastro.php">Criar conta</a></p>
    </section>
</div>

<script>
    const botaoSenha = document.querySelector("[data-senha]");
    const campoSenha = document.getElementById("senha");

    botaoSenha.addEventListener("click", function() {
        if (campoSenha.type == "password") {
            campoSenha.type = "text";
            botaoSenha.textContent = "Ocultar";
            botaoSenha.setAttribute("aria-pressed", "true");
        } else {
            campoSenha.type = "password";
            botaoSenha.textContent = "Mostrar";
            botaoSenha.setAttribute("aria-pressed", "false");
        }
    });
</script>

<?php
include("estrutura/rodape.php");
?>