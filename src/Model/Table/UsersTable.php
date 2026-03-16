<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{
    // ----------------------------------------------------------
    // initialize()
    // Configura o behavior Timestamp e a relação com Articles.
    // ----------------------------------------------------------
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Preenche automaticamente created e modified
        $this->addBehavior('Timestamp');

        // Relação: um utilizador pode ter vários artigos
        $this->hasMany('Articles');
    }

    // ----------------------------------------------------------
    // validationDefault()
    // Regras de validação para o registo de utilizadores.
    // ----------------------------------------------------------
    public function validationDefault(Validator $validator): Validator
    {
        // Regra 1: Username obrigatório com mínimo de 3 caracteres
        $validator
            ->notEmptyString('username', 'O nome de utilizador é obrigatório.')
            ->minLength('username', 3, 'O nome deve ter pelo menos 3 caracteres.');

        // Regra 2: Email válido e obrigatório
        $validator
            ->notEmptyString('email', 'O email é obrigatório.')
            ->email('email', false, 'Introduza um email válido.');

        // Regra 3: Password obrigatória com mínimo de 6 caracteres
        $validator
            ->notEmptyString('password', 'A palavra-passe é obrigatória.')
            ->minLength('password', 6, 'A palavra-passe deve ter pelo menos 6 caracteres.');

        return $validator;
    }

    // ----------------------------------------------------------
    // beforeSave()
    // Evento executado ANTES de guardar na base de dados.
    // Encripta a password usando o algoritmo bcrypt (PASSWORD_BCRYPT).
    // Só encripta se for um registo novo (isNew) para não re-encriptar
    // passwords já guardadas durante uma edição.
    // ----------------------------------------------------------
    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !empty($entity->password)) {
            // password_hash() gera um hash seguro com bcrypt
            $entity->password = password_hash($entity->password, PASSWORD_BCRYPT);
        }
        return true;
    }
}