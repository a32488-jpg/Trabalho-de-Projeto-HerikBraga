<!-- ============================================================
     templates/Articles/edit.php
     VIEW - Formulário para editar artigo existente (ação edit)

     Idêntico ao add.php mas os campos vêm pré-preenchidos
     com os dados atuais do artigo carregado pelo controller.
     ============================================================ -->
<div style="max-width: 680px; margin: 0 auto;">

    <div class="page-header">
        <h1>Editar Artigo</h1>
    </div>

    <div style="background: white; border-radius: 12px; padding: 2.5rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); border: 1px solid #e5e7eb;">

        <!-- $article contém os dados atuais do artigo (pré-preenchidos) -->
        <?= $this->Form->create($article) ?>

            <!-- Campo título pré-preenchido com o valor atual -->
            <?= $this->Form->control('title', ['label' => 'Título']) ?>

            <!-- Dropdown de categorias com a categoria atual selecionada -->
            <?= $this->Form->control('category_id', [
                'label'  => 'Categoria',
                'options' => $categories,
                'empty'  => '-- Selecione uma categoria --',
            ]) ?>

            <!-- Campo conteúdo pré-preenchido -->
            <?= $this->Form->control('body', [
                'label' => 'Conteúdo',
                'rows'  => 10,
            ]) ?>

            <div style="display:flex; gap:1rem; margin-top:1rem; align-items:center;">
                <?= $this->Form->button('Guardar Alterações') ?>
                <!-- Link para cancelar e voltar à lista -->
                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'back-link']) ?>
            </div>

        <?= $this->Form->end() ?>
    </div>

</div>