<!-- ============================================================
     templates/Categories/index.php
     VIEW - Lista de categorias (ação index)

     Apresenta todas as categorias em tabela.
     Utilizadores autenticados podem criar, editar e eliminar.
     ============================================================ -->

<?php $loggedIn = $this->request->getSession()->read('Auth.User'); ?>

<div class="page-header">
    <h1>Categorias</h1>
    <!-- Botão "Nova Categoria" apenas para autenticados -->
    <?php if ($loggedIn): ?>
        <?= $this->Html->link('+ Nova Categoria', ['action' => 'add'], ['class' => 'btn']) ?>
    <?php endif; ?>
</div>

<?php if ($categories->count() === 0): ?>
    <p style="color:#6b7280; font-style:italic;">Ainda não existem categorias.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Criada em</th>
                <?php if ($loggedIn): ?>
                    <th>Ações</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <!-- Nome da categoria -->
                    <td><?= h($category->name) ?></td>

                    <!-- Data de criação formatada -->
                    <td><?= $category->created->format('d/m/Y') ?></td>

                    <!-- Ações disponíveis para utilizadores autenticados -->
                    <?php if ($loggedIn): ?>
                        <td>
                            <!-- Link para edit.php da categoria -->
                            <?= $this->Html->link('Editar', ['action' => 'edit', $category->id]) ?>

                            <!-- Botão POST para eliminar com confirmação -->
                            <?= $this->Form->postLink(
                                'Eliminar',
                                ['action' => 'delete', $category->id],
                                ['confirm' => 'Tem a certeza que quer eliminar esta categoria?']
                            ) ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<!-- Navegação: link para voltar aos artigos -->
<?= $this->Html->link('← Artigos', ['controller' => 'Articles', 'action' => 'index'], ['class' => 'back-link']) ?>