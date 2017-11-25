<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Customer\Attribute\Edit\Tab;

class Front extends \Magento\Backend\Block\Widget\Form\Generic
{
public $yesNo;
public $usedCustomerForms;
private $propertyLocker;

public function __construct(
\Magento\Backend\Block\Template\Context $context,
\Magento\Framework\Registry $registry,
\Magento\Framework\Data\FormFactory $formFactory,
\Magento\Config\Model\Config\Source\Yesno $yesNo,
\Bhartendukumar\Attribute\Model\Config\Source\UsedCustomerForms $usedCustomerForms,
\Magento\Eav\Block\Adminhtml\Attribute\PropertyLocker $propertyLocker,
array $data = []
) {
$this->yesNo = $yesNo;
$this->usedCustomerForms = $usedCustomerForms;
$this->propertyLocker = $propertyLocker;
parent::__construct($context, $registry, $formFactory, $data);
}
public function _prepareForm()
{
$attributeObject = $this->_coreRegistry->registry('entity_attribute');
$yesnoSource = $this->yesNo->toOptionArray();
$usedCustomerFormsSource = $this->usedCustomerForms->toOptionArray();

$form = $this->_formFactory->create(
['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
);
$fieldset = $form->addFieldset(
'front_fieldset',
['legend' => __('Storefront Properties'), 'collapsable' => $this->getRequest()->has('popup')]
);

$fieldset->addField(
'is_visible',
'select',
[
'name'=> 'is_visible',
'label'=> __('Show on Storefront'),
'title'=> __('Show on Storefront'),
'values'=> $yesnoSource,
'value' => $attributeObject->getIsVisible()
]
);

$fieldset->addField(
'sort_order',
'text',
[
'name' => 'sort_order',
'label' => __('Sort Order'),
'title' => __('Sort Order'),
'value' => $attributeObject->getSortOrder()
]
);

$fieldset->addField(
'used_in_forms',
'multiselect',
[
'name' => 'used_in_forms',
'label' => __('Forms to Use In'),
'title' => __('Forms to Use In'),
'values'=> $usedCustomerFormsSource,
'value' => $attributeObject->getUsedInForms()
]
);

$this->setForm($form);
$form->setValues($attributeObject->getData());
$this->propertyLocker->lock($form);
return parent::_prepareForm();
}
}
