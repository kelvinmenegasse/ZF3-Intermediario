<?php

namespace Blog\Controller;

use Blog\Form\CommentForm;
use Blog\Model\PostTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostController extends AbstractActionController
{

    private $table;

    public function __construct(PostTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        $postTable = $this->table;
        return new ViewModel([
            'posts' => $postTable->fetchAll()
        ]);
    }

    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('post');
        }

        try {

            $post = $this->table->find($id);

        } catch (\Exception $e) {

            return $this->redirect()->toRoute('post');

        }

        return new ViewModel([
            'post' => $post
        ]);

    }
}