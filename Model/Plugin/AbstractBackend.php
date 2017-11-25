<?php

namespace Bhartendukumar\Attribute\Model\Plugin;

class AbstractBackend
{
public $customerAttributeCollection;

public function __construct(
\Magento\Customer\Model\ResourceModel\Attribute\CollectionFactory $customerAttributeCollection
) {
$this->customerAttributeCollection = $customerAttributeCollection;
}

public function beforeValidate($subject, $object)
{
//customer
$collection = $this->customerAttributeCollection->create();
$collection->addFieldToFilter('is_user_defined', 1);
$collection->addFieldToFilter('is_required', 1);
if (!empty($collection)) {
foreach ($collection as $key => $attribute) {
$attribute_code = $attribute->getAttributeCode();
if (!$object->getData($attribute_code)) {
$object->setData($attribute_code, 'NULL');
}
}
}

return [$object];
}
}
