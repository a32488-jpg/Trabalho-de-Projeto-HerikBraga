<!-- ============================================================

     VIEW - Lista de todos os artigos (ação index)

     Apresenta todos os artigos com: título, excerto, categoria,
     autor e data. Se o utilizador tiver login, mostra também
     os botões de editar e eliminar.
     ============================================================ -->

<!-- Cabeçalho da página com botão "Novo Artigo" (só para autenticados) -->
<div class="page-header">
    <h1>Artigos</h1>
    <?php if ($loggedIn): ?>
        <!-- Link para a view add.php - criar novo artigo -->
        <?= $this->Html->link('+ Novo Artigo', ['action' => 'add'], ['class' => 'btn']) ?>
    <?php endif; ?>
</div>

<!-- Mensagem quando não existem artigos -->
<?php if ($articles->count() === 0): ?>
    <p style="color:#6b7280; font-style:italic;">Ainda não existem artigos publicados.</p>

<?php else: ?>
    <!-- Lista de artigos -->
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <div class="article-card">

                <!-- Badge com o nome da categoria -->
                <span class="category-badge"><?= h($article->category->name) ?></span>

                <!-- Título do artigo com link para view.php -->
                <h2><?= $this->Html->link(h($article->title), ['action' => 'view', $article->id]) ?></h2>

                <!-- Excerto do conteúdo (primeiros 150 caracteres) -->
                <p class="article-excerpt">
                    <?= h(mb_strimwidth($article->body, 0, 150, '...')) ?>
                </p>

                <!-- Metadados: autor, data e link "Ler mais" -->
                <div class="article-meta">
                    <span>Por <strong><?= h($article->user->username) ?></strong></span>
                    <span><?= $article->created->format('d/m/Y') ?></span>
                    <!-- Link para a view completa do artigo -->
                    <?= $this->Html->link('Ler mais →', ['action' => 'view', $article->id]) ?>
                </div>

                <!-- Botões de gestão (apenas visíveis para utilizadores autenticados) -->
                <?php if ($loggedIn): ?>
                    <div class="article-actions">
                        <!-- Link para a view edit.php -->
                        <?= $this->Html->link('✏️ Editar', ['action' => 'edit', $article->id]) ?>

                        <!-- postLink gera um formulário POST para a ação delete -->
                        <!-- confirm: mostra uma caixa de confirmação antes de eliminar -->
                        <?= $this->Form->postLink(
                            '🗑️ Eliminar',
                            ['action' => 'delete', $article->id],
                            ['confirm' => 'Tem a certeza que quer eliminar "' . h($article->title) . '"?']
                        ) ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>