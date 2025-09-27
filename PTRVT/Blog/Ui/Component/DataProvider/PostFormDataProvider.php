<?php
namespace PTRVT\Blog\Ui\Component\DataProvider;

use Magento\Framework\Registry;
use Magento\Ui\DataProvider\AbstractDataProvider;
use PTRVT\Blog\Model\ResourceModel\Post\CollectionFactory;

class PostFormDataProvider extends AbstractDataProvider
{
    protected $collection;
    protected $loadedData;
    protected $registry;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        Registry $registry,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->registry = $registry;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $post = $this->registry->registry('ptrvt_blog_post');
        if ($post && $post->getId()) {
            $this->loadedData[$post->getId()] = $post->getData();
        }

        return $this->loadedData ?? [];
    }
}