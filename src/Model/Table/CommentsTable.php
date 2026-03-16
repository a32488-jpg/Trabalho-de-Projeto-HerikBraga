<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CommentsTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Preenche automaticamente created e modified
        $this->addBehavior('Timestamp');

        // Relação: um comentário PERTENCE a um artigo (chave: article_id)
        $this->belongsTo('Articles');
    }

    // ----------------------------------------------------------
    // validationDefault()
    // Validação dos campos do comentário.
    // ----------------------------------------------------------
    public function validationDefault(Validator $validator): Validator
    {
        // Regra 1: Nome do autor obrigatório
        $validator->notEmptyString('author', 'O seu nome é obrigatório.');

        // Regra 2: Texto do comentário obrigatório
        $validator->notEmptyString('body', 'O comentário não pode estar vazio.');

        return $validator;
    }
}