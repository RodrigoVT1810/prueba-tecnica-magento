<?php
namespace PTRVT\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use PTRVT\Blog\Model\PostFactory;
use Magento\Framework\Registry;
use Magento\Backend\Model\Session;

class View extends Action
{
    const ADMIN_RESOURCE = 'PTRVT_Blog::posts';

    protected $postFactory;
    protected $registry;
    protected $backendSession;

    public function __construct(
        Action\Context $context,
        PostFactory $postFactory,
        Registry $registry,
        Session $backendSession = null // 👈 hacerlo opcional
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->registry = $registry;
        $this->backendSession = $backendSession ?: $context->getSession(); // 👈 fallback
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->postFactory->create()->load($id);

        if (!$model->getId()) {
            $this->messageManager->addErrorMessage(__('This post no longer exists.'));
            return $this->_redirect('*/*/index');
        }

        $this->registry->register('ptrvt_blog_post', $model);
        $this->backendSession->setData('current_post_id', $id);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('View Post: %1', $model->getTitle()));
        return $resultPage;
    }
}