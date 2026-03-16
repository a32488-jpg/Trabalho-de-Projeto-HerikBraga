<!-- ============================================================
     templates/Articles/search.php
     VIEW - Resultados da pesquisa (ação search)

     Apresenta os artigos que correspondem à palavra-chave
     pesquisada. Se não existirem resultados, informa o utilizador.
     ============================================================ -->

<!-- Título com a palavra pesquisada -->
<h1>Resultados para: "<?= h($keyword) ?>"</h1>

<?php if (empty($keyword)): ?>
    <!-- Nenhuma palavra-chave introduzida -->
    <p>Introduza um termo para pesquisar.</p>

<?php elseif ($articles->count() === 0): ?>
    <!-- Pesquisa sem resultados -->
    <p>Nenhum artigo encontrado para "<?= h($keyword) ?>".</p>

<?php else: ?>
    <!-- Número de resultados encontrados -->
    <p style="color:#6b7280; margin-bottom:1.5rem;">
        <?= $articles->count() ?> artigo(s) encontrado(s).
    </p>

    <!-- Lista de artigos encontrados (mesmo layout do index.php) -->
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <div class="article-card">
                <span class="category-badge"><?= h($article->category->name) ?></span>

                <!-- Link para a view completa do artigo -->
                <h2><?= $this->Html->link(h($article->title), ['controller' => 'Articles', 'action' => 'view', $article->id]) ?></h2>

                <p class="article-excerpt"><?= h(mb_strimwidth($article->body, 0, 150, '...')) ?></p>

                <div class="article-meta">
                    <span>Por <strong><?= h($article->user->username) ?></strong></span>
                    <span><?= $article->created->format('d/m/Y') ?></span>
                    <?= $this->Html->link('Ler mais →', ['controller' => 'Articles', 'action' => 'view', $article->id]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- Navegação: link para voltar à lista principal -->
<?= $this->Html->link('← Voltar aos artigos', ['controller' => 'Articles', 'action' => 'index'], ['class' => 'back-link']) ?>