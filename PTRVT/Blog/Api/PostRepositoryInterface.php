<?php
namespace PTRVT\Blog\Api;

use PTRVT\Blog\Api\Data\PostInterface;

interface PostRepositoryInterface
{
    /**
     * @return array
     */
    public function getList();

    /**
     * @param int $id
     * @return array
     */
    public function getById($id);
}