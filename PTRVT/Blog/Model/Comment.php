<?php
namespace PTRVT\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Comment extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\PTRVT\Blog\Model\ResourceModel\Comment::class);
    }
}