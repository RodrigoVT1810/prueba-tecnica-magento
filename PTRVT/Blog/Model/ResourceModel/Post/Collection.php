<?php
namespace PTRVT\Blog\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'ptrvt_blog_post_collection';
    protected $_eventObject = 'post_collection';

    protected function _construct()
    {
        $this->_init(
            \PTRVT\Blog\Model\Post::class,
            \PTRVT\Blog\Model\ResourceModel\Post::class
        );
    }
}