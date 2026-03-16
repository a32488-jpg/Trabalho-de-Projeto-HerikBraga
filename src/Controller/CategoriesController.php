<?php
// ============================================================
//  CONTROLLER das Categorias
//
//  Permite criar, listar, editar e eliminar categorias.
//  Todas as ações de escrita requerem login.
//
//  Ações disponíveis:
//    index()  → listar categorias
//    add()    → criar nova categoria (requer login)
//    edit()   → editar categoria (requer login)
//    delete() → eliminar categoria (requer login)
// ============================================================
namespace App\Controller;

use App\Controller\AppController;

class CategoriesController extends AppController
{
    // ----------------------------------------------------------
    // index()
    // Lista todas as categorias por ordem alfabética.
    // URL: /categories
    // ----------------------------------------------------------
    public function index()
    {
        // Obtém todas as categorias ordenadas pelo nome
        $categories = $this->Categories->find('all')->order(['name' => 'ASC']);

        $this->set('categories', $categories);
    }

    // ----------------------------------------------------------
    // add()
    // Apresenta o formulário para criar uma nova categoria (GET)
    // e processa a criação quando submetido (POST).
    // Requer login.
    // URL: /categories/add
    // ----------------------------------------------------------
    public function add()
    {
        $this->requireLogin();

        $category = $this->Categories->newEmptyEntity();

        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success('Categoria criada com sucesso!');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Não foi possível criar a categoria.');
        }

        $this->set('category', $category);
    }

    // ----------------------------------------------------------
    // edit($id)
    // Edita uma categoria existente.
    // Requer login.
    // URL: /categories/edit/1
    // ----------------------------------------------------------
    public function edit($id = null)
    {
        $this->requireLogin();

        // Carrega a categoria pelo id
        $category = $this->Categories->get($id);

        if ($this->request->is(['post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            if ($this->Categories->save($category)) {
                $this->Flash->success('Categoria atualizada!');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Não foi possível atualizar a categoria.');
        }

        $this->set('category', $category);
    }

    // ----------------------------------------------------------
    // delete($id)
    // Elimina uma categoria da BD.
    // Só aceita pedidos POST ou DELETE (segurança).
    // Requer login.
    // URL: /categories/delete/1 (via formulário POST)
    // ----------------------------------------------------------
    public function delete($id = null)
    {
        $this->requireLogin();

        // Restringe o método HTTP (evita eliminação acidental por link)
        $this->request->allowMethod(['post', 'delete']);

        $category = $this->Categories->get($id);

        if ($this->Categories->delete($category)) {
            $this->Flash->success('Categoria eliminada!');
        } else {
            $this->Flash->error('Não foi possível eliminar a categoria.');
        }

        return $this->redirect(['action' => 'index']);
    }
}