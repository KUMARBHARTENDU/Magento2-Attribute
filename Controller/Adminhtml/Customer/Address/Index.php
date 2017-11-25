<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Customer\Address;

class Index extends \Bhartendukumar\Attribute\Controller\Adminhtml\Customer\Address
{
public function execute()
{
$this->_initAction();
$this->_view->getPage()->getConfig()->getTitle()->prepend(__('Customer Address Attribute'));
$this->_view->renderLayout();
}
}
