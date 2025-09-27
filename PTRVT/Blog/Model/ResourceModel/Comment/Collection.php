<?php
namespace PTRVT\Blog\Model\ResourceModel\Comment;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\PTRVT\Blog\Model\Comment::class, \PTRVT\Blog\Model\ResourceModel\Comment::class);
    }
}