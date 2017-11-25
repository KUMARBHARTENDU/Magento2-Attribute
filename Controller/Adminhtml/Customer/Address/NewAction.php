<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Customer\Address;

class NewAction extends \Bhartendukumar\Attribute\Controller\Adminhtml\Customer\Address
{
public function execute()
{
return $this->resultForwardFactory->create()->forward('edit');
}
}
