<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Customer\Address\Attribute;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
public $_blockGroup = 'Bhartendukumar_Attribute';
public $coreRegistry = null;

public function __construct(
\Magento\Backend\Block\Widget\Context $context,
\Magento\Framework\Registry $registry,
array $data = []
) {
$this->coreRegistry = $registry;
parent::__construct($context, $data);
}

public function _construct()
{
$this->_objectId = 'attribute_id';
$this->_controller = 'adminhtml_customer_address_attribute';
parent::_construct();
$this->addButton(
'save_and_edit_button',
[
'label' => __('Save and Continue Edit'),
'class' => 'save',
'data_attribute' => [
'mage-init' => [
'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
],
]
]
);

$this->buttonList->update('save', 'label', __('Save Attribute'));
$this->buttonList->update('save', 'class', 'save primary');
$this->buttonList->update(
'save',
'data_attribute',
['mage-init' => ['button' => ['event' => 'save', 'target' => '#edit_form']]]
);

$entityAttribute = $this->coreRegistry->registry('entity_attribute');
if (!$entityAttribute || !$entityAttribute->getIsUserDefined()) {
$this->buttonList->remove('delete');
} else {
$this->buttonList->update('delete', 'label', __('Delete Attribute'));
}
}

public function getHeaderText()
{
if ($this->coreRegistry->registry('entity_attribute')->getId()) {
$frontendLabel = $this->coreRegistry->registry('entity_attribute')->getFrontendLabel();
if (is_array($frontendLabel)) {
$frontendLabel = $frontendLabel[0];
}
return __('Edit Customer Address Attribute "%1"', $this->escapeHtml($frontendLabel));
}
return __('New Customer Address Attribute');
}

public function getSaveUrl()
{
return $this->getUrl(
'bhartendukumar_attribute_manager/customer_address/save',
['_current' => true, 'back' => null, 'address_tab' => $this->getRequest()->getParam('address_tab')]
);
}
}
