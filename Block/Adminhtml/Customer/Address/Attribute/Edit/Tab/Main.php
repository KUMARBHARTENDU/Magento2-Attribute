<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Customer\Address\Attribute\Edit\Tab;

class Main extends \Magento\Eav\Block\Adminhtml\Attribute\Edit\Main\AbstractMain
{
public function _prepareForm()
{
parent::_prepareForm();

$attributeObject = $this->getAttributeObject();
$form = $this->getForm();
$fieldset = $form->getElement('base_fieldset');

$fiedsToRemove = ['is_unique', 'frontend_class'];
foreach ($fieldset->getElements() as $element) {
if (substr($element->getId(), 0, strlen('default_value')) == 'default_value') {
$fiedsToRemove[] = $element->getId();
}
}
foreach ($fiedsToRemove as $id) {
$fieldset->removeField($id);
}

$frontendInputElm = $form->getElement('frontend_input');
$frontendInputElm->setValues($frontendInputElm->getValues())->setLabel('Input Type')->setTitle('Input Type');

if ($attributeObject->getData('source_model') == 'Magento\Eav\Model\Entity\Attribute\Source\Boolean') {
$attributeObject->setData('frontend_input', 'boolean');
}

return $this;
}
}
