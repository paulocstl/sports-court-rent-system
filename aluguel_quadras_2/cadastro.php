<?php
$titulo = "Crie sua conta";
include("estrutura/cabecalho.php");
?>

<div class="auth">
    <section>
        <p class="etiqueta">FAÇA PARTE DO JOGO</p>
        <h1>Crie sua conta</h1>
        <p>Faça seu cadastro</p>
    </section>

    <section class="painel">
        <h2>Cadastro</h2>

            <form action="cadastro_salvar.php" method="post">

            <label for="nome">Nome completo</label>
            <input id="nome" name="nome" autocomplete="name"
                   minlength="3" maxlength="60" required>

            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf"
            inputmode="numeric" minlength="11" maxlength="11"
            pattern="[0-9]{11}" placeholder="Somente números" required>

            <label for="telefone">Telefone</label>
            <input type="tel" id="telefone" name="telefone"
            autocomplete="tel" maxlength="20" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email"
                   autocomplete="email" maxlength="100" required>

            <label for="senha">Senha</label>
            <div class="senha">
                <input type="password" id="senha" name="senha"
                       autocomplete="new-password" minlength="8"
                       required aria-describedby="dica-senha">

                <button type="button" data-senha
                        aria-controls="senha" aria-pressed="false">
                    Mostrar
                </button>

            </div>

            <p id="dica-senha" class="ajuda">
                Use pelo menos 8 caracteres.
            </p>

            <label for="confirmar">Confirmar senha</label>
            <input type="password" id="confirmar" name="confirmar"
                   autocomplete="new-password" minlength="8" required>

            <button class="botao" type="submit">Cadastrar</button>

        </form>

        <p>Já tem conta? <a href="login.php">Entrar</a></p>
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