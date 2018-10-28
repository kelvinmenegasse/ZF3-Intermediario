<?php

namespace Blog\Model;

// PostTable é a classe que vai representar nossa tabela no banco de dados
// TableGateway o que faz a gente conversar com a nossa tabela em formato de objeto

use Zend\Db\TableGateway\TableGatewayInterface;
use Zend\Db\TableGateway\Exception\RuntimeException;

class PostTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;

    }

    public function fetchAll() {

        return $this->tableGateway->select();

    }

    public function save(Post $post)
    {
        $data = [
            'title' => $post->title,
            'content' => $post->content,
        ];
        
        $id = (int) $post->id;
        
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->find($id)){
            throw new RuntimeException(sprintf('Could not retrieve the row %d', $id));
        }
        
        $this->tableGateway->update($data, ['id'=> $id]);

    }
    
    public function find($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id'=>$id]);
        $row = $rowset->current();

        if (!$row) {
            throw new RuntimeException(sprintf('Could not retrieve the row %d', $id));
        }

        return $row;

    }

    public function delete($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
