<!DOCTYPE html>
<!-- ============================================================
     templates/layout/default.php
     LAYOUT GLOBAL DA APLICAÇÃO

     Este ficheiro envolve todas as views da aplicação.
     Contém a estrutura HTML base: cabeçalho, navbar, rodapé.
     O conteúdo de cada view é inserido em: $this->fetch('content')
     ============================================================ -->
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Online</title>
    <!-- Fontes Google: Playfair Display (títulos) + Source Sans 3 (texto) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Source+Sans+3:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Folha de estilos principal (webroot/css/style.css) -->
    <?= $this->Html->css('style') ?>
</head>
<body>

<!-- ============================================================
     BARRA DE NAVEGAÇÃO PRINCIPAL
     Contém: logo, barra de pesquisa e links de navegação.
     Os links de login/registo são substituídos por "Novo Artigo"
     e "Sair" quando o utilizador tem sessão iniciada.
     ============================================================ -->
<nav>
    <!-- Logo / Nome do blog -->
    <div class="nav-brand">
        <?= $this->Html->link('<span>B</span>log Online', ['controller' => 'Articles', 'action' => 'index'], ['escape' => false]) ?>
    </div>

    <!-- Formulário de pesquisa rápida -->
    <form action="/cakephp/Trabalho_Projeto/articles/search" method="get" class="search-form">
        <input type="text" name="q" placeholder="Pesquisar artigos..." value="<?= h($this->request->getQuery('q')) ?>">
        <button type="submit">Pesquisar</button>
    </form>

    <!-- Links de navegação -->
    <div class="nav-links">
        <!-- Links sempre visíveis -->
        <?= $this->Html->link('Artigos',    ['controller' => 'Articles',   'action' => 'index']) ?>
        <?= $this->Html->link('Categorias', ['controller' => 'Categories', 'action' => 'index']) ?>

        <!-- Links condicionais: dependem de o utilizador estar autenticado -->
        <?php if ($this->request->getSession()->read('Auth.User')): ?>
            <!-- Utilizador autenticado: mostra opções de gestão -->
            <?= $this->Html->link('+ Novo Artigo', ['controller' => 'Articles', 'action' => 'add']) ?>
            <?= $this->Html->link('Sair',          ['controller' => 'Users',    'action' => 'logout']) ?>
        <?php else: ?>
            <!-- Utilizador não autenticado: mostra login e registo -->
            <?= $this->Html->link('Login',    ['controller' => 'Users', 'action' => 'login']) ?>
            <?= $this->Html->link('Registar', ['controller' => 'Users', 'action' => 'register']) ?>
        <?php endif; ?>
    </div>
</nav>

<!-- ============================================================
     ÁREA DE CONTEÚDO PRINCIPAL
     Flash: mensagens de feedback (sucesso/erro)
     content: conteúdo da view atual
     ============================================================ -->
<div class="container">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</div>

<!-- ============================================================
     RODAPÉ
     ============================================================ -->
<footer>
    <p>Blog Online &copy; <?= date('Y') ?> &nbsp;·&nbsp; Módulo 13 &nbsp;·&nbsp; CakePHP &nbsp;·&nbsp; PSI 12</p>
</footer>

</body>
</html>