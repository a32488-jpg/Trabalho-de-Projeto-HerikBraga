<!-- ============================================================
     templates/Categories/edit.php
     VIEW - Formulário para editar categoria (ação edit)
     ============================================================ -->
<div style="max-width: 500px; margin: 0 auto;">

    <div class="page-header">
        <h1>Editar Categoria</h1>
    </div>

    <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 16px rgba(0,0,0,0.07); border: 1px solid #e5e7eb;">

        <!-- $category contém os dados atuais (pré-preenchidos) -->
        <?= $this->Form->create($category) ?>
            <?= $this->Form->control('name', ['label' => 'Nome da Categoria']) ?>

            <div style="display:flex; gap:1rem; margin-top:1rem; align-items:center;">
                <?= $this->Form->button('Guardar') ?>
                <!-- Navegação: link para voltar à lista -->
                <?= $this->Html->link('Cancelar', ['action' => 'index'], ['class' => 'back-link']) ?>
            </div>
        <?= $this->Form->end() ?>

    </div>
</div>