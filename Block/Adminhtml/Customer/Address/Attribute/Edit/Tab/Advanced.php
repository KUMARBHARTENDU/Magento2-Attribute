<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Customer\Address\Attribute\Edit\Tab;

class Advanced extends \Magento\Backend\Block\Widget\Form\Generic
{
public $yesNo;
public $eavData;

public function __construct(
\Magento\Backend\Block\Template\Context $context,
\Magento\Framework\Registry $registry,
\Magento\Framework\Data\FormFactory $formFactory,
\Magento\Config\Model\Config\Source\Yesno $yesNo,
\Magento\Eav\Helper\Data $eavData,
array $data = []
) {
$this->yesNo = $yesNo;
$this->eavData = $eavData;
parent::__construct($context, $registry, $formFactory, $data);
}

public function _prepareForm()
{
$yesno = $this->yesNo->toOptionArray();
$attributeObject = $this->getAttributeObject();

$form = $this->_formFactory->create(
['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
);
$fieldset = $form->addFieldset(
'advanced_fieldset',
['legend' => __('Advanced Attribute Properties'), 'collapsable' => true]
);

$fieldset->addField(
'default_value_text',
'text',
[
'name' => 'default_value_text',
'label' => __('Default Value'),
'title' => __('Default Value'),
'value' => $attributeObject->getDefaultValue()
]
);

$fieldset->addField(
'default_value_yesno',
'select',
[
'name' => 'default_value_yesno',
'label' => __('Default Value'),
'title' => __('Default Value'),
'values' => $yesno,
'value' => $attributeObject->getDefaultValue()
]
);

$fieldset->addField(
'default_value_date',
'date',
[
'name' => 'default_value_date',
'label' => __('Default Value'),
'title' => __('Default Value'),
'value' => $attributeObject->getDefaultValue(),
'date_format' => 'M/d/yyyy'
]
);

$fieldset->addField(
'default_value_textarea',
'textarea',
[
'name' => 'default_value_textarea',
'label' => __('Default Value'),
'title' => __('Default Value'),
'value' => $attributeObject->getDefaultValue()
]
);

$fieldset->addField(
'frontend_class',
'select',
[
'name' => 'frontend_class',
'label' => __('Input Validation'),
'title' => __('Input Validation'),
'values' => $this->eavData->getFrontendClasses($attributeObject->getEntityType()->getEntityTypeCode())
]
);

$fieldset->addField(
'is_visible_in_grid',
'hidden',
[
'name' => 'is_visible_in_grid',
'value' => $attributeObject->getData('is_visible_in_grid') ?: 1,
]
);

$fieldset->addField(
'is_searchable_in_grid',
'hidden',
[
'name' => 'is_searchable_in_grid',
'value' => $attributeObject->getData('is_searchable_in_grid') ?: 1,
]
);
$this->setForm($form);
return $this;
}

public function _initFormValues()
{
$this->getForm()->addValues($this->getAttributeObject()->getData());
return parent::_initFormValues();
}

private function getAttributeObject()
{
return $this->_coreRegistry->registry('entity_attribute');
}
}
