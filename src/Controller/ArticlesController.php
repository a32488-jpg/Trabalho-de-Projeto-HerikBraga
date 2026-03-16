<?php
// ============================================================
//  CONTROLLER dos Artigos
//
//  O Controller é responsável por:
//    - Receber os pedidos HTTP do browser
//    - Comunicar com o Model para aceder aos dados
//    - Selecionar a View correta para apresentar ao utilizador
//
//  Convenções CakePHP:
//    - Nome no plural + "Controller": ArticlesController
//    - Ficheiro: src/Controller/ArticlesController.php
//    - Cada método público é uma "ação" acessível por URL
//
//  Ações disponíveis:
//    index()  → listar todos os artigos
//    view()   → ver um artigo + comentários
//    add()    → criar novo artigo (requer login)
//    edit()   → editar artigo existente (requer login)
//    delete() → eliminar artigo (requer login)
//    search() → pesquisar artigos por palavra-chave
// ============================================================
namespace App\Controller;

use App\Controller\AppController;

class ArticlesController extends AppController
{
    // ----------------------------------------------------------
    // index()
    // Lista todos os artigos ordenados do mais recente para o mais antigo.
    // contain() carrega dados relacionados (utilizador e categoria)
    // para evitar múltiplas consultas à BD (eager loading).
    // Acessível a todos os utilizadores (sem login).
    // URL: /articles
    // ----------------------------------------------------------
    public function index()
    {
        // Busca todos os artigos com os dados do utilizador e categoria
        $articles = $this->Articles->find('all')
            ->contain(['Users', 'Categories']) // Carrega relações
            ->order(['Articles.created' => 'DESC']); // Mais recentes primeiro

        // Passa os dados para a view Articles/index.php
        $this->set('articles', $articles);

        // Passa o estado de login para mostrar/esconder botões de edição
        $this->set('loggedIn', $this->isLoggedIn());
    }

    // ----------------------------------------------------------
    // view($id)
    // Mostra um artigo específico com todos os seus comentários.
    // Recebe o $id do artigo como parâmetro na URL.
    // Também trata o formulário de adição de comentários (POST).
    // URL: /articles/view/1
    // ----------------------------------------------------------
    public function view($id = null)
    {
        // Carrega o artigo pelo id, incluindo utilizador, categoria e comentários
        $article = $this->Articles->get($id, [
            'contain' => ['Users', 'Categories', 'Comments'],
        ]);

        // Cria uma entidade vazia para o formulário de novo comentário
        $comment = $this->Articles->Comments->newEmptyEntity();

        // Verifica se o formulário de comentário foi submetido (método POST)
        if ($this->request->is('post')) {

            // Preenche a entidade com os dados do formulário
            // Adiciona também o article_id automaticamente
            $comment = $this->Articles->Comments->patchEntity(
                $comment,
                $this->request->getData() + ['article_id' => $id]
            );

            // Tenta guardar o comentário na BD
            if ($this->Articles->Comments->save($comment)) {
                $this->Flash->success('Comentário publicado com sucesso!');
                // Redireciona para a mesma página para evitar resubmissão do formulário
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error('Não foi possível publicar o comentário.');
        }

        $this->set('loggedIn', $this->isLoggedIn());
        $this->set(compact('article', 'comment'));
    }

    // ----------------------------------------------------------
    // add()
    // Apresenta o formulário para criar um novo artigo (GET)
    // e processa o formulário quando submetido (POST).
    // Requer login — chama requireLogin() para verificar.
    // URL: /articles/add
    // ----------------------------------------------------------
    public function add()
    {
        // Verifica se o utilizador está autenticado
        $this->requireLogin();

        // Cria uma entidade vazia para o formulário
        $article = $this->Articles->newEmptyEntity();

        // Verifica se o formulário foi submetido
        if ($this->request->is('post')) {

            // Preenche a entidade com os dados do formulário
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            // Obtém o utilizador da sessão e associa ao artigo
            $user = $this->request->getSession()->read('Auth.User');
            $article->user_id = $user['id'];

            // Tenta guardar na BD (as validações são verificadas aqui)
            if ($this->Articles->save($article)) {
                $this->Flash->success('Artigo publicado com sucesso!');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Não foi possível publicar o artigo. Verifique os campos.');
        }

        // Carrega a lista de categorias para o dropdown do formulário
        $categories = $this->Articles->Categories->find('list')->order(['name' => 'ASC']);
        $this->set(compact('article', 'categories'));
    }

    // ----------------------------------------------------------
    // edit($id)
    // Apresenta o formulário de edição de um artigo (GET)
    // e guarda as alterações quando submetido (PUT/POST).
    // Requer login.
    // URL: /articles/edit/1
    // ----------------------------------------------------------
    public function edit($id = null)
    {
        // Verifica autenticação
        $this->requireLogin();

        // Carrega o artigo pelo id (lança exceção se não existir)
        $article = $this->Articles->get($id);

        // Processa o formulário se foi submetido via POST ou PUT
        if ($this->request->is(['post', 'put'])) {

            // Atualiza a entidade com os novos dados
            $article = $this->Articles->patchEntity($article, $this->request->getData());

            if ($this->Articles->save($article)) {
                $this->Flash->success('Artigo atualizado com sucesso!');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Não foi possível atualizar o artigo.');
        }

        // Carrega categorias para o dropdown
        $categories = $this->Articles->Categories->find('list')->order(['name' => 'ASC']);
        $this->set(compact('article', 'categories'));
    }

    // ----------------------------------------------------------
    // delete($id)
    // Elimina um artigo da base de dados.
    // Só aceita pedidos POST ou DELETE (segurança).
    // Os comentários associados são eliminados automaticamente
    // graças ao 'dependent' => true no Model.
    // Requer login.
    // URL: /articles/delete/1 (via formulário POST)
    // ----------------------------------------------------------
    public function delete($id = null)
    {
        // Verifica autenticação
        $this->requireLogin();

        // Só permite métodos POST ou DELETE (evita eliminação acidental por URL)
        $this->request->allowMethod(['post', 'delete']);

        // Carrega o artigo a eliminar
        $article = $this->Articles->get($id);

        // Tenta eliminar o artigo (e os comentários associados)
        if ($this->Articles->delete($article)) {
            $this->Flash->success('Artigo eliminado com sucesso!');
        } else {
            $this->Flash->error('Não foi possível eliminar o artigo.');
        }

        // Redireciona para a lista de artigos
        return $this->redirect(['action' => 'index']);
    }

    // ----------------------------------------------------------
    // search()
    // Pesquisa artigos por palavra-chave no título ou conteúdo.
    // Recebe o parâmetro 'q' via GET (query string).
    // URL: /articles/search?q=cakephp
    // ----------------------------------------------------------
    public function search()
    {
        // Obtém a palavra-chave da query string (?q=...)
        $keyword  = $this->request->getQuery('q', '');
        $articles = [];

        // Só pesquisa se a palavra-chave não estiver vazia
        if (!empty($keyword)) {
            // Chama o método search() definido no ArticlesTable
            $articles = $this->Articles->search($keyword);
        }

        $this->set('loggedIn', $this->isLoggedIn());
        $this->set(compact('articles', 'keyword'));
    }
}