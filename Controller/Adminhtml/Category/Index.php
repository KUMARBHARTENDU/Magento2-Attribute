<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Category;

class Index extends \Bhartendukumar\Attribute\Controller\Adminhtml\Category
{
public function execute()
{
$this->_initAction();
$this->_view->getPage()->getConfig()->getTitle()->prepend(__('Category Attribute'));
$this->_view->renderLayout();
}
}
