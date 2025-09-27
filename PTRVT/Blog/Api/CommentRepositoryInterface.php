<?php
namespace PTRVT\Blog\Api;

use PTRVT\Blog\Api\Data\CommentInterface;

interface CommentRepositoryInterface
{
    /**
     * @param int $postId
     * @return array
     */
    public function getByPostId($postId);
}