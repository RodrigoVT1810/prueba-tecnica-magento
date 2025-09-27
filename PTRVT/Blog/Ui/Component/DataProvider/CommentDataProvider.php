<?php
namespace PTRVT\Blog\Ui\Component\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use PTRVT\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Backend\Model\Session;

class CommentDataProvider extends AbstractDataProvider
{
    protected $request;
    protected $backendSession;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        Session $backendSession,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->request = $request;
        $this->backendSession = $backendSession;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        $postId = (int)($this->request->getParam('post_id') ?: $this->backendSession->getData('current_post_id'));

        if ($postId) {
            $this->collection->addFieldToFilter('post_id', $postId);
        }
        return $this->collection->toArray();
    }
}