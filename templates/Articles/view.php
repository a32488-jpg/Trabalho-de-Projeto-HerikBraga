<!-- templates/Articles/view.php -->
<article class="article-full">

    <span class="category-badge"><?= h($article->category->name) ?></span>

    <h1><?= h($article->title) ?></h1>

    <div class="article-meta-full">
        <span>Por <strong><?= h($article->user->username) ?></strong></span>
        <span><?= $article->created->format('d/m/Y \à\s H:i') ?></span>
    </div>

    <div class="article-body">
        <?= nl2br(h($article->body)) ?>
    </div>

    <?php if ($loggedIn): ?>
        <div class="article-actions" style="margin-top:1.5rem; padding-top:1rem; border-top:1px solid #e5e7eb;">
            <?= $this->Html->link('Editar', ['action' => 'edit', $article->id]) ?>
            <?= $this->Form->postLink('Eliminar',
                ['action' => 'delete', $article->id],
                ['confirm' => 'Tem a certeza?']
            ) ?>
        </div>
    <?php endif; ?>
</article>

<hr>

<!-- COMENTÁRIOS -->
<section class="comments">
    <h2>Comentários (<?= count($article->comments) ?>)</h2>

    <?php if (empty($article->comments)): ?>
        <p style="color:#6b7280; font-style:italic;">Ainda não há comentários. Seja o primeiro!</p>
    <?php else: ?>
        <?php foreach ($article->comments as $comment): ?>
            <div class="comment-card">
                <strong><?= h($comment->author) ?></strong>
                <span class="comment-date"><?= $comment->created->format('d/m/Y') ?></span>
                <p><?= nl2br(h($comment->body)) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <h3>Deixar um comentário</h3>
    <?= $this->Form->create($comment) ?>
        <?= $this->Form->control('author', ['label' => 'O seu nome']) ?>
        <?= $this->Form->control('body',   ['label' => 'Comentário', 'rows' => 4]) ?>
        <?= $this->Form->button('Publicar comentário') ?>
    <?= $this->Form->end() ?>
</section>

<?= $this->Html->link('← Voltar aos artigos', ['action' => 'index'], ['class' => 'back-link']) ?>