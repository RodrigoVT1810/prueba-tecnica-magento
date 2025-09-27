<?php
namespace PTRVT\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use PTRVT\Blog\Model\PostFactory;
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

class Save extends Action
{
    protected $postFactory;

    public function __construct(
        Action\Context $context,
        PostFactory $postFactory
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            unset($data['form_key']);
            if (empty($data['post_id'])) {
                unset($data['post_id']); // 🔥 forzamos insert
            }

            $model = $this->postFactory->create();

            if (!empty($data['post_id'])) {
                $model->load($data['post_id']);
            }

            $model->addData($data);

            // 👉 Configurar logger para save.log
            $logger = new MonoLogger('save');
            $logger->pushHandler(new StreamHandler(BP . '/var/log/save.log', MonoLogger::DEBUG));

            try {
                $model->save();

                $logger->info('✅ Insert/Update exitoso', $model->getData());

                $this->messageManager->addSuccessMessage(__('The post has been saved.'));

                // Crear 2 comentarios automáticamente si es un nuevo post
                if (!$this->getRequest()->getParam('post_id')) {
                    $commentFactory = $this->_objectManager->create(\PTRVT\Blog\Model\CommentFactory::class);

                    $comment1 = $commentFactory->create();
                    $comment1->setData([
                        'post_id' => $model->getId(),
                        'comment' => 'Primer comentario automático'
                    ]);
                    $comment1->save();

                    $logger->info('✅ Insert comentario #1 exitoso', $comment1->getData());

                    $comment2 = $commentFactory->create();
                    $comment2->setData([
                        'post_id' => $model->getId(),
                        'comment' => 'Segundo comentario automático'
                    ]);
                    $comment2->save();

                    $logger->info('✅ Insert comentario #2 exitoso', $comment2->getData());
                }
            } catch (\Exception $e) {
                $logger->error('❌ Error al guardar', ['exception' => $e->getMessage()]);
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }
}