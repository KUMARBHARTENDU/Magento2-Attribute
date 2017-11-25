<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml;

abstract class Category extends \Magento\Backend\App\Action
{
public $resultForwardFactory;
public $categoryAttribute;
public $bhartendukumarHelper;
public $eventManager;
public $backendSession;

public function __construct(
\Magento\Backend\App\Action\Context $context,
\Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
\Magento\Catalog\Model\ResourceModel\Eav\Attribute $categoryAttribute,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper
) {
parent::__construct($context);

$this->resultForwardFactory = $resultForwardFactory;
$this->categoryAttribute = $categoryAttribute;
$this->bhartendukumarHelper = $bhartendukumarHelper;
$this->eventManager = $context->getEventManager();
$this->backendSession = $context->getSession();
}

public function _initAction()
{
$this->_view->loadLayout();
$this->_setActiveMenu(
'Bhartendukumar_Attribute::category_attribute'
);
return $this;
}

public function _isAllowed()
{
return $this->_authorization->isAllowed('Bhartendukumar_Attribute::category_attribute');
}

public function getEntityTypeId()
{
return $this->bhartendukumarHelper->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
}
}
