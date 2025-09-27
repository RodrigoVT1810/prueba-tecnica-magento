<?php
namespace PTRVT\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    const ADMIN_RESOURCE = 'PTRVT_Blog::posts';

    protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('PTRVT_Blog::blog');
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Posts'));
        return $resultPage;
    }
}