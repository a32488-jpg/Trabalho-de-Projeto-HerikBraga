<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CategoriesTable extends Table
{
    
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Preenche automaticamente created e modified
        $this->addBehavior('Timestamp');

        // Relação: uma categoria pode ter vários artigos
        $this->hasMany('Articles');
    }

    // ----------------------------------------------------------
    // validationDefault()
    // Validação: o nome da categoria é obrigatório.
    // ----------------------------------------------------------
    public function validationDefault(Validator $validator): Validator
    {
        $validator->notEmptyString('name', 'O nome da categoria é obrigatório.');

        return $validator;
    }
}