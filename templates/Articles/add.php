<!-- ============================================================
     templates/Articles/add.php
     VIEW - Formulário para criar novo artigo (ação add)

     Apresenta um formulário com os campos:
       - Título (obrigatório)
       - Categoria (dropdown, obrigatório)
       - Conteúdo (obrigatório)
     As validações são definidas no ArticlesTable.php
     ============================================================ -->
<div style="max-width: 680px; margin: 0 auto;">

    <div class="page-header">
        <h1>Novo Artigo</h1>
    </div>

    <div style="background: white; border-radius: 12px; padding: 2.5rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); border: 1px solid #e5e7eb;">

        <!-- $article é a entidade vazia criada no controller -->
        <!-- O CakePHP gera automaticamente o action correto (POST /articles/add) -->
        <?= $this->Form->create($article) ?>

            <!-- Campo: Título do artigo -->
            <?= $this->Form->control('title', [
                'label'       => 'Título',
                'placeholder' => 'Escreva um título para o artigo...',
            ]) ?>

            <!-- Campo: Categoria (dropdown gerado a partir do $categories do controller) -->
            <?= $this->Form->control('category_id', [
                'label'  => 'Categoria',
                'options' => $categories,
                'empty'  => '-- Selecione uma categoria --',
            ]) ?>

            <!-- Campo: Conteúdo do artigo -->
            <?= $this->Form->control('body', [
                'label'       => 'Conteúdo',
                'rows'        => 10,
                'placeholder' => 'Escreva o conteúdo do artigo aqui...',
            ]) ?>

            <!-- Botões de ação -->
            <div style="display:flex; gap:1rem; margin-top:1rem; align-items:center;">
                <?= $this->Form->button('Publicar Artigo') ?>
                <!-- Link de cancelar → volta para index.php -->
                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'back-link']) ?>
            </div>

        <?= $this->Form->end() ?>
    </div>

</div>