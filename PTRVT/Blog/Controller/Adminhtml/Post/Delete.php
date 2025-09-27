<?php
namespace PTRVT\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use PTRVT\Blog\Model\PostFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'PTRVT_Blog::posts';

    protected $postFactory;

    public function __construct(
        Action\Context $context,
        PostFactory $postFactory
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        if ($id) {
            try {
                $model = $this->postFactory->create()->load($id);
                if (!$model->getId()) {
                    throw new \Exception(__('This post no longer exists.'));
                }

                $model->delete();

                $this->messageManager->addSuccessMessage(__('The post has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $this->_redirect('*/*/edit', ['post_id' => $id]);
            }
        }

        return $this->_redirect('*/*/index');
    }
}