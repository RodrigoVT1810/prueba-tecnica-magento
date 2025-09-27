<?php
namespace PTRVT\Blog\Model\Resolver;

use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use PTRVT\Blog\Model\ResourceModel\Post\CollectionFactory as PostCollectionFactory;
use PTRVT\Blog\Model\ResourceModel\Comment\CollectionFactory as CommentCollectionFactory;

class Post implements ResolverInterface
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
        $id = (int) ($args['id'] ?? 0);
        if (!$id) {
            throw new NoSuchEntityException(__('Post ID is required'));
        }

        $collection = $this->postCollectionFactory->create();
        $post = $collection->getItemById($id);

        if (!$post) {
            throw new NoSuchEntityException(__('Post not found'));
        }

        return [
            'post_id'    => (int) $post->getId(),
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
                'comment_id' => (int) $comment->getId(),
                'post_id'    => (int) $comment->getPostId(),
                'comment'    => $comment->getComment(),
                'created_at' => $comment->getCreatedAt()
            ];
        }

        return $comments;
    }
}