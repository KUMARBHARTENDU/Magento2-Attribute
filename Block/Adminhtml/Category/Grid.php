<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Category;

class Grid extends \Magento\Eav\Block\Adminhtml\Attribute\Grid\AbstractGrid
{
public $collectionFactory;

public function __construct(
\Magento\Backend\Block\Template\Context $context,
\Magento\Backend\Helper\Data $backendHelper,
\Magento\Catalog\Model\ResourceModel\Category\Attribute\CollectionFactory $collectionFactory,
array $data = []
) {
$this->collectionFactory = $collectionFactory;
parent::__construct($context, $backendHelper, $data);
}

public function _prepareCollection()
{
$collection = $this->collectionFactory->create();
$collection->addFieldToFilter('is_user_defined', 1);
$this->setCollection($collection);
return parent::_prepareCollection();
}

public function _prepareColumns()
{
parent::_prepareColumns();
return $this;
}

public function getRowUrl($row)
{
return $this->getUrl(
'bhartendukumar_attribute_manager/edit',
['store' => $this->getRequest()->getParam('store'), 'attribute_id' => $row->getId()]
);
}
}
