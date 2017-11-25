<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Customer;

abstract class Address extends \Magento\Backend\App\Action
{
public $resultForwardFactory;
public $customerAddressAttribute;
public $bhartendukumarHelper;
public $backendSession;

public function __construct(
\Magento\Backend\App\Action\Context $context,
\Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
\Magento\Customer\Model\Attribute $customerAddressAttribute,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper
) {
parent::__construct($context);
$this->resultForwardFactory = $resultForwardFactory;
$this->customerAddressAttribute = $customerAddressAttribute;
$this->bhartendukumarHelper = $bhartendukumarHelper;
$this->backendSession = $context->getSession();
}

public function _initAction()
{
$this->_view->loadLayout();
$this->_setActiveMenu(
'Bhartendukumar_Attribute::customer_address_attribute'
);
return $this;
}

public function _isAllowed()
{
return $this->_authorization->isAllowed('Bhartendukumar_Attribute::customer_address_attribute');
}

public function getEntityTypeId()
{
$entity_type = \Magento\Customer\Api\AddressMetadataInterface::ENTITY_TYPE_ADDRESS;
return $this->bhartendukumarHelper->getEntityTypeId($entity_type);
}
}
