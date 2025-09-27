<?php
namespace PTRVT\Blog\Model;

use PTRVT\Blog\Api\PostRepositoryInterface;
use PTRVT\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use PTRVT\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class PostRepository implements PostRepositoryInterface
{
    protected $postCollectionFactory;
    protected $commentCollectionFactory;

    public function __construct(
        PostCollectionFactory $postCollectionFactory,
        CommentCollectionFactory $commentCollectionFactory
    ) {
        $this->postCollectionFactory = $postCollectionFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
    }

    public function getList()
    {
        $collection = $this->postCollectionFactory->create();
        $result = [];

        foreach ($collection as $post) {
            $result[] = [
                'post_id'    => $post->getId(),
                'title'      => $post->getTitle(),
                'content'    => $post->getContent(),
                'created_at' => $post->getCreatedAt(),
                'updated_at' => $post->getUpdatedAt(),
                'comments'   => $this->getCommentsByPostId($post->getId())
            ];
        }

        return $result;
    }

    public function getById($id)
    {
        $post = $this->postCollectionFactory->create()->getItemById($id);
        if (!$post) {
            throw new NoSuchEntityException(__('Post not found'));
        }

        return [
            'post_id'    => $post->getId(),
            'title'      => $post->getTitle(),
            'content'    => $post->getContent(),
            'created_at' => $post->getCreatedAt(),
            'updated_at' => $post->getUpdatedAt(),
            'comments'   => $this->getCommentsByPostId($post->getId())
        ];
    }

    private function getCommentsByPostId($postId)
    {
        $comments = [];
        $collection = $this->commentCollectionFactory->create();
        $collection->addFieldToFilter('post_id', $postId);

        foreach ($collection as $comment) {
            $comments[] = [
                'comment_id' => $comment->getId(),
                'content'    => $comment->getComment(),
                'created_at' => $comment->getCreatedAt()
            ];
        }

        return $comments;
    }
}
