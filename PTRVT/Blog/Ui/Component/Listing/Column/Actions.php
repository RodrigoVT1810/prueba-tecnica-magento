<?php
namespace PTRVT\Blog\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class Actions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                if (isset($item['post_id'])) {
                    // Botón View
                    $item[$this->getData('name')]['view'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'blog/post/view',
                            ['post_id' => $item['post_id']]
                        ),
                        'label' => __('View')
                    ];

                    // Botón Edit
                    $item[$this->getData('name')]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'blog/post/edit',
                            ['post_id' => $item['post_id']]
                        ),
                        'label' => __('Edit')
                    ];

                    // Botón Delete
                    $item[$this->getData('name')]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'blog/post/delete',
                            ['post_id' => $item['post_id']]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete Post'),
                            'message' => __('Are you sure you want to delete post?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}