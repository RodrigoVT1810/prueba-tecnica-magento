<?php
namespace PTRVT\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;

class Add extends Action
{
    const ADMIN_RESOURCE = 'PTRVT_Blog::posts';

    public function execute()
    {
        $this->_forward('edit');
    }
}