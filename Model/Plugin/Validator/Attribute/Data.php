<?php

namespace Bhartendukumar\Attribute\Model\Plugin\Validator\Attribute;

class Data
{
public $customerAddressAttributeCollection;
public $bhartendukumarHelper;

public function __construct(
\Magento\Customer\Model\ResourceModel\Address\Attribute\CollectionFactory $customerAddressAttributeCollection,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper
) {
$this->customerAddressAttributeCollection = $customerAddressAttributeCollection;
$this->bhartendukumarHelper = $bhartendukumarHelper;
}

public function beforeIsValid($subject, $entity)
{
$class = get_class($entity->getDataModel());

//customer address
if ($class == 'Magento\Customer\Model\Data\Address') {
$addressCollection = $this->customerAddressAttributeCollection->create();
$addressCollection->addFieldToFilter('is_user_defined', 1);
$addressCollection->addFieldToFilter('is_required', 1);
if (!empty($addressCollection)) {
foreach ($addressCollection as $key => $attribute) {
$attribute_id = $attribute->getAttributeId();
$used_in_forms = $this->getUsedInForms($attribute_id);

if (!in_array('customer_register_address', $used_in_forms) || !in_array('customer_address_edit', $used_in_forms)) {
$attribute_code = $attribute->getAttributeCode();
if (!$entity->getData($attribute_code)) {
$default_value = $attribute->getDefaultValue();
if ($default_value) {
$entity->setData($attribute_code, $default_value);
} else {
if ($attribute->getFrontendInput() == 'date') {
$entity->setData($attribute_code, date("m/d/Y"));
} else {
$entity->setData($attribute_code, 'NULL');
}
}
}
}
}
}
}

return [$entity];
}

public function getUsedInForms($attribute_id)
{
return $this->bhartendukumarHelper->getUsedInForms($attribute_id, $this->getEntityTypeId());
}

public function getEntityTypeId()
{
return $this->bhartendukumarHelper->getEntityTypeId(\Magento\Customer\Model\Customer::ENTITY);
}
}
