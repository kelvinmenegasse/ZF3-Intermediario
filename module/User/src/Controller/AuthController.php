<?php

namespace User\Controller;

use User\Form\LoginForm;
use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;

class AuthController extends AbstractActionController
{
    private $authService;
    
    public function __construct(AuthenticationServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function loginAction()
    {
        
        if ($this->authService->hasIdentity()){
            return $this->redirect()->toRoute('admin-blog/post');
        }

        $form = new LoginForm();
        $messageError = null;

        $request = $this->getRequest();

        if ($request->isPost())
        {
            // verifica o login do usuario
            $data = $request->getPost();
            $form->setData($data);
            
            if ($form->isValid())
            {   
                $formData = $form->getData();
                // $authadapter = CallbackCheckAdapter
                $authAdapter = $this->authService->getAdapter();
                $authAdapter->setIdentity($formData['username']);
                $authAdapter->setCredential($formData['password']);

                $result = $this->authService->authenticate();
                
                if ($result->isValid())
                {                 
                    return $this->redirect()->toRoute('admin-blog/post');

                } else {
                    $messageError = 'Login ou senha inválidos';
                }
            }
        }

        return new ViewModel([
            'form' => $form,
            'messageError' => $messageError
        ]);
    }

    public function logoutAction()
    {
       $this->authService->clearIdentity();
       return $this->redirect()->toRoute('login');
    }

}