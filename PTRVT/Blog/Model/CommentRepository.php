<?php
namespace PTRVT\Blog\Model;

use PTRVT\Blog\Api\CommentRepositoryInterface;
use PTRVT\Blog\Model\ResourceModel\Comment\CollectionFactory;

class CommentRepository implements CommentRepositoryInterface
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getByPostId($postId)
    {
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('post_id', $postId);
        return $collection->getData();
    }
}