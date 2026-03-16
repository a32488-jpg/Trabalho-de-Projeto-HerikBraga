<?php
// ============================================================
//  CONTROLLER dos Utilizadores
//
//  Gere o registo, login e logout dos utilizadores.
//  Utiliza sessões PHP nativas do CakePHP para autenticação
//  (sem necessidade de instalar plugins externos).
//
//  Ações disponíveis:
//    login()    → formulário e processamento do login
//    logout()   → terminar sessão
//    register() → formulário e processamento do registo
// ============================================================
namespace App\Controller;

use App\Controller\AppController;

class UsersController extends AppController
{
    // ----------------------------------------------------------
    // login()
    // Apresenta o formulário de login (GET) e verifica as
    // credenciais quando submetido (POST).
    //
    // Processo de autenticação:
    //   1. Procura o utilizador pelo username na BD
    //   2. Verifica a password com password_verify() (bcrypt)
    //   3. Se válido, guarda os dados na sessão
    //   4. Redireciona para a lista de artigos
    //
    // URL: /users/login
    // ----------------------------------------------------------
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        // Processa o formulário de login
        if ($this->request->is('post')) {

            // Obtém os dados submetidos no formulário
            $username = $this->request->getData('username');
            $password = $this->request->getData('password');

            // Procura o utilizador na BD pelo username
            $user = $this->Users->findByUsername($username)->first();

            // Verifica se o utilizador existe E se a password está correta
            // password_verify() compara o texto com o hash bcrypt guardado na BD
            if ($user && password_verify($password, $user->password)) {

                // Guarda os dados do utilizador na sessão
                $this->request->getSession()->write('Auth.User', [
                    'id'       => $user->id,
                    'username' => $user->username,
                    'email'    => $user->email,
                ]);

                $this->Flash->success('Bem-vindo, ' . $user->username . '!');

                // Redireciona para a lista de artigos após login bem sucedido
                return $this->redirect(['controller' => 'Articles', 'action' => 'index']);
            }

            // Credenciais inválidas — não revela qual campo está errado (segurança)
            $this->Flash->error('Utilizador ou palavra-passe incorretos.');
        }
    }

    // ----------------------------------------------------------
    // logout()
    // Termina a sessão do utilizador eliminando os dados de sessão.
    // Redireciona para a página de login.
    // URL: /users/logout
    // ----------------------------------------------------------
    public function logout()
    {
        // Elimina os dados de autenticação da sessão
        $this->request->getSession()->delete('Auth.User');

        $this->Flash->success('Sessão terminada. Até breve!');

        // Redireciona para o login
        return $this->redirect(['action' => 'login']);
    }

    // ----------------------------------------------------------
    // register()
    // Apresenta o formulário de registo (GET) e cria uma nova
    // conta quando submetido (POST).
    // A password é encriptada automaticamente pelo beforeSave()
    // definido no UsersTable.
    // URL: /users/register
    // ----------------------------------------------------------
    public function register()
    {
        // Cria uma entidade vazia para o formulário
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {

            // Preenche a entidade com os dados do formulário
            $user = $this->Users->patchEntity($user, $this->request->getData());

            // Tenta guardar na BD (as validações são verificadas aqui)
            // O beforeSave() do UsersTable encripta a password automaticamente
            if ($this->Users->save($user)) {
                $this->Flash->success('Conta criada com sucesso! Pode agora fazer login.');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('Não foi possível criar a conta. Verifique os dados.');
        }

        $this->set('user', $user);
    }
}