<?php
namespace PTRVT\Blog\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use PTRVT\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use PTRVT\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

class Posts implements ResolverInterface
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

    public function resolve($field, $context, $info, array $value = null, array $args = null)
    {
        $collection = $this->postCollectionFactory->create();
        $result = [];

        foreach ($collection as $post) {
            $result[] = [
                'post_id'    => (int) $post->getId(),
                'title'      => $post->getTitle(),
                'content'    => $post->getContent(),
                'created_at' => $post->getCreatedAt(),
                'updated_at' => $post->getUpdatedAt(),
                'comments'   => $this->getCommentsByPostId($post->getId())
            ];
        }

        return $result;
    }

    private function getCommentsByPostId($postId)
    {
        $comments = [];
        $collection = $this->commentCollectionFactory->create();
        $collection->addFieldToFilter('post_id', $postId);

        foreach ($collection as $comment) {
            $comments[] = [
                'comment_id' => (int) $comment->getId(),
                'post_id'    => (int) $comment->getPostId(),
                'comment'    => $comment->getComment(),
                'created_at' => $comment->getCreatedAt()
            ];
        }

        return $comments;
    }
}