<!-- ============================================================
     templates/Users/login.php
     VIEW - Formulário de Login (ação login)

     Apresenta um formulário simples com username e password.
     O controller UsersController::login() verifica as credenciais
     e inicia a sessão se forem válidas.
     ============================================================ -->
<div class="form-page">

    <h1>Login</h1>

    <!-- Formulário POST para /users/login -->
    <?= $this->Form->create() ?>

        <!-- Campo: Nome de utilizador -->
        <?= $this->Form->control('username', ['label' => 'Nome de utilizador']) ?>

        <!-- Campo: Palavra-passe (type="password" oculta o texto) -->
        <?= $this->Form->control('password', ['label' => 'Palavra-passe', 'type' => 'password']) ?>

        <?= $this->Form->button('Entrar') ?>

    <?= $this->Form->end() ?>

    <!-- Navegação: link para a página de registo -->
    <p>Não tem conta? <?= $this->Html->link('Criar conta', ['action' => 'register']) ?></p>

    <!-- Navegação: link para voltar aos artigos sem fazer login -->
    <p><?= $this->Html->link('← Ver artigos sem login', ['controller' => 'Articles', 'action' => 'index']) ?></p>

</div>