<?php
namespace PTRVT\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use PTRVT\Blog\Model\PostFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'PTRVT_Blog::posts';

    protected $postFactory;
    protected $coreRegistry;

    public function __construct(
        Action\Context $context,
        PostFactory $postFactory,
        Registry $coreRegistry
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
        $this->coreRegistry = $coreRegistry;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->postFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This post no longer exists.'));
                return $this->_redirect('*/*/index');
            }
        }

        // Registrar el modelo en el registro global
        $this->coreRegistry->register('ptrvt_blog_post', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(
            $model->getId() ? __('Edit Post: %1', $model->getTitle()) : __('New Post')
        );

        return $resultPage;
    }
}