<?php
namespace PTRVT\Blog\Model;

use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\PTRVT\Blog\Model\ResourceModel\Post::class);
    }
}