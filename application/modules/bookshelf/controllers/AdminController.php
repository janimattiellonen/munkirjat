<?php

class Bookshelf_AdminController extends Munkirjat_Controller_Action
{
    public function clearAction()
    {
        $this->getCache('content')->clean();
        
        die('Caches cleared');
    }
    
}