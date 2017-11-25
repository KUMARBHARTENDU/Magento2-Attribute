<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml;

abstract class Customer extends \Magento\Backend\App\Action
{
public $resultForwardFactory;
public $customerAttribute;
public $bhartendukumarHelper;
public $backendSession;

public function __construct(
\Magento\Backend\App\Action\Context $context,
\Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
\Magento\Customer\Model\Attribute $customerAttribute,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper
) {
parent::__construct($context);

$this->resultForwardFactory = $resultForwardFactory;
$this->customerAttribute = $customerAttribute;
$this->bhartendukumarHelper = $bhartendukumarHelper;
$this->backendSession = $context->getSession();
}

public function _initAction()
{
$this->_view->loadLayout();
$this->_setActiveMenu(
'Bhartendukumar_Attribute::customer_attribute'
);
return $this;
}

public function _isAllowed()
{
return $this->_authorization->isAllowed('Bhartendukumar_Attribute::customer_attribute');
}

public function getEntityTypeId()
{
return $this->bhartendukumarHelper->getEntityTypeId(\Magento\Customer\Model\Customer::ENTITY);
}
}
