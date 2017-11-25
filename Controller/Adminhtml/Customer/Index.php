<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Customer;

class Index extends \Bhartendukumar\Attribute\Controller\Adminhtml\Customer
{
public function execute()
{
$this->_initAction();
$this->_view->getPage()->getConfig()->getTitle()->prepend(__('Customer Attribute'));
$this->_view->renderLayout();
}
}
