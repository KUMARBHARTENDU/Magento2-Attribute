<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Category;

class Edit extends \Bhartendukumar\Attribute\Controller\Adminhtml\Category
{
public function execute()
{
$id = $this->getRequest()->getParam('attribute_id');
$model = $this->categoryAttribute->setEntityTypeId($this->getEntityTypeId());
if ($id) {
$model->load($id);

if (!$model->getId()) {
$this->messageManager->addError(__('This attribute no longer exists.'));
$resultRedirect = $this->resultRedirectFactory->create();
return $resultRedirect->setPath('bhartendukumar_attribute_manager/');
}
if ($model->getEntityTypeId() != $this->getEntityTypeId()) {
$this->messageManager->addError(__('This attribute cannot be edited.'));
$resultRedirect = $this->resultRedirectFactory->create();
return $resultRedirect->setPath('bhartendukumar_attribute_manager/');
}
}
$data = $this->backendSession->getAttributeData(true);
if (!empty($data)) {
$model->addData($data);
}

$attributeData = $this->getRequest()->getParam('attribute');
if (!empty($attributeData) && $id === null) {
$model->addData($attributeData);
}

$this->bhartendukumarHelper->getCoreRegistry()->register('entity_attribute', $model);
$title = __('Add Category Attribute');
if ($id) {
$title = __('Edit Category Attribute');
}
$this->_initAction();
$this->_view->getPage()->getConfig()->getTitle()->prepend($title);
$this->_view->renderLayout();
}
}
