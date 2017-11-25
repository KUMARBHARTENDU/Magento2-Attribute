<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Customer;

class NewAction extends \Bhartendukumar\Attribute\Controller\Adminhtml\Customer
{
public function execute()
{
return $this->resultForwardFactory->create()->forward('edit');
}
}
