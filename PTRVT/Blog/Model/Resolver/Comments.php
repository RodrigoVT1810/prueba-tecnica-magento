<?php
namespace PTRVT\Blog\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use PTRVT\Blog\Model\ResourceModel\Comment\CollectionFactory;

class Comments implements ResolverInterface
{
    protected $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    public function resolve($field, $context, $info, array $value = null, array $args = null)
    {
        return $this->collectionFactory->create()->getData();
    }
}