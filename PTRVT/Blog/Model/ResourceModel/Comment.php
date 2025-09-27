<?php
namespace PTRVT\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comment extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ptrvt_blog_comment', 'comment_id');
    }
}