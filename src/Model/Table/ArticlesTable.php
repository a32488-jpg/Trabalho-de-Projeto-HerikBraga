<?php

//  src/Model/Table/ArticlesTable.php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    
    // Método chamado automaticamente ao inicializar o Model.
    // Aqui configuram-se os behaviors e as relações com outras tabelas.
  
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Timestamp Behavior: preenche automaticamente os campos
        // "created" (na inserção) e "modified" (na atualização)
        $this->addBehavior('Timestamp');

        // Relação: um artigo PERTENCE a um utilizador (chave: user_id)
        $this->belongsTo('Users');

        // Relação: um artigo PERTENCE a uma categoria (chave: category_id)
        $this->belongsTo('Categories');

        // Relação: um artigo TEM MUITOS comentários
        // dependent: true → ao apagar o artigo, apaga também os comentários
        $this->hasMany('Comments', [
            'dependent' => true,
        ]);
    }

    // ----------------------------------------------------------
    // validationDefault()
    // Define as regras de validação aplicadas quando se chama save().
    // Mínimo de 2 regras conforme pedido no enunciado.
    // ----------------------------------------------------------
    public function validationDefault(Validator $validator): Validator
    {
        // Regra 1: O título não pode estar vazio
        $validator->notEmptyString('title', 'O título do artigo é obrigatório.');

        // Regra 2: O conteúdo não pode estar vazio
        $validator->notEmptyString('body', 'O conteúdo do artigo é obrigatório.');

        // Regra 3: É obrigatório selecionar uma categoria
        $validator->notEmptyString('category_id', 'Deve selecionar uma categoria.');

        return $validator;
    }


    // Método personalizado para pesquisar artigos por palavra-chave.
    // Pesquisa no título e no conteúdo do artigo.
    // Carrega também os dados do utilizador e da categoria.

    public function search(string $keyword)
    {
        return $this->find()
            ->contain(['Users', 'Categories']) // Carrega dados relacionados
            ->where([
                'OR' => [
                    'Articles.title LIKE' => '%' . $keyword . '%', // Pesquisa no título
                    'Articles.body LIKE'  => '%' . $keyword . '%', // Pesquisa no conteúdo
                ],
            ])
            ->order(['Articles.created' => 'DESC']); // Mais recentes primeiro
    }
}