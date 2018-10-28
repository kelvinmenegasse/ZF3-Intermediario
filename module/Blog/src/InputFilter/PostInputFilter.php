<?php

namespace Blog\InputFilter;

use Zend\Filter\StripTags;
use Zend\Filter\StringTrim;
use Zend\Validator\NotEmpty;
use Zend\InputFilter\InputFilter;

class PostInputFilter extends InputFilter
{

    public function __construct()
    {   
        $this->add([
            'name' => 'id',         // em um novo cadastro, não existe id
            'required' => true,     // se required for true, sempre dará erro ao cadastrar
            'allow_empty' => true   // por isso, utilizamos essa propriedade para permitir um id vazio
        ]);

        $this->add([
            'name' => 'title',
            'required' => true,
            'filters' => [
                ['name' => StringTrim::class],
                ['name' => StripTags::class],
            ],
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'O campo é requerido!',
                            NotEmpty::INVALID => 'O campo é inválido' 
                        ]
                    ]
                ]
            ],
        ]);

        $this->add([
            'name' => 'content',
            'required' => true,
            'validators' => [
                [
                    'name' => NotEmpty::class,
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'O campo é requerido!',
                            NotEmpty::INVALID => 'O campo é inválido' 
                        ]
                    ]
                ]
            ],
        ]);

    }


}