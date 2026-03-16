<!-- ============================================================
     templates/Users/register.php
     VIEW - Formulário de Registo (ação register)

     Permite criar uma nova conta de utilizador.
     A password é encriptada automaticamente pelo beforeSave()
     do UsersTable antes de ser guardada na BD.
     ============================================================ -->
<div class="form-page">

    <h1>Criar Conta</h1>

    <!-- Formulário POST para /users/register -->
    <!-- $user é a entidade com os erros de validação (se existirem) -->
    <?= $this->Form->create($user) ?>

        <!-- Campo: Nome de utilizador (único na BD) -->
        <?= $this->Form->control('username', ['label' => 'Nome de utilizador']) ?>

        <!-- Campo: Email (único na BD) -->
        <?= $this->Form->control('email', ['label' => 'Email']) ?>

        <!-- Campo: Palavra-passe (será encriptada com bcrypt) -->
        <?= $this->Form->control('password', ['label' => 'Palavra-passe', 'type' => 'password']) ?>

        <?= $this->Form->button('Criar Conta') ?>

    <?= $this->Form->end() ?>

    <!-- Navegação: link para o login se já tiver conta -->
    <p>Já tem conta? <?= $this->Html->link('Fazer login', ['action' => 'login']) ?></p>

</div>