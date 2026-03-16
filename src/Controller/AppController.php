<?php

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{

    public function initialize(): void
    {
        parent::initialize();

        // Flash Component: permite mostrar mensagens de sucesso/erro
        // ao utilizador após ações (ex: "Artigo guardado com sucesso")
        $this->loadComponent('Flash');
    }

    // ----------------------------------------------------------
    // isLoggedIn()
    // Verifica se existe um utilizador com sessão iniciada.
    // Lê a variável de sessão 'Auth.User' guardada no login.
    // Retorna TRUE se estiver autenticado, FALSE caso contrário.
    // ----------------------------------------------------------
    public function isLoggedIn(): bool
    {
        return (bool) $this->request->getSession()->read('Auth.User');
    }

    // ----------------------------------------------------------
    // requireLogin()
    // Protege ações que requerem autenticação.
    // Se o utilizador não estiver autenticado, redireciona
    // para a página de login com uma mensagem de aviso.
    // ----------------------------------------------------------
    public function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $this->Flash->error('Precisa de fazer login para aceder a esta página.');
            $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
}