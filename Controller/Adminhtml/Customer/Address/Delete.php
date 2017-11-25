<?php

namespace Bhartendukumar\Attribute\Controller\Adminhtml\Customer\Address;

class Delete extends \Bhartendukumar\Attribute\Controller\Adminhtml\Customer\Address
{
public function execute()
{
$id = $this->getRequest()->getParam('attribute_id');
$resultRedirect = $this->resultRedirectFactory->create();
if ($id) {
$model = $this->customerAddressAttribute;
$model->load($id);
if ($model->getEntityTypeId() != $this->getEntityTypeId()) {
$this->messageManager->addError(__('We can\'t delete the attribute.'));
return $resultRedirect->setPath('bhartendukumar_attribute_manager/');
}

try {
$model->delete();
$this->messageManager->addSuccess(__('You deleted the customer address attribute.'));
return $resultRedirect->setPath('bhartendukumar_attribute_manager/');
} catch (\Exception $e) {
$this->messageManager->addError($e->getMessage());
return $resultRedirect->setPath(
'bhartendukumar_attribute_manager/edit',
['attribute_id' => $this->getRequest()->getParam('attribute_id')]
);
}
}
$this->messageManager->addError(__('We can\'t find an attribute to delete.'));
return $resultRedirect->setPath('bhartendukumar_attribute_manager/');
}
}
