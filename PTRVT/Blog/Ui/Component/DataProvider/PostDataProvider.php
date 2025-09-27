<?php
namespace PTRVT\Blog\Ui\Component\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use PTRVT\Blog\Model\ResourceModel\Post\CollectionFactory;

class PostDataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        return [
            'totalRecords' => $this->collection->getSize(),
            'items' => $this->collection->getData(),
        ];
    }
}
