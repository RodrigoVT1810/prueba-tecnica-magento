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

                $this->messageManager->addSuccessMessage(__('The post has been saved. ID: %1', $model->getId()));
            } catch (\Exception $e) {
                $logger->error('❌ Error al guardar', ['exception' => $e->getMessage()]);
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }
}