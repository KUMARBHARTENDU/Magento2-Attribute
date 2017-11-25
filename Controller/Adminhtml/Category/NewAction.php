<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Category;

class NewAction extends \Bhartendukumar\Attribute\Controller\Adminhtml\Category
{
public function execute()
{
return $this->resultForwardFactory->create()->forward('edit');
}
}
