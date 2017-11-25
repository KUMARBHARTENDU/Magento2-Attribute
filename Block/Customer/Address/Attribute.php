<?php

namespace Bhartendukumar\Attribute\Block\Customer\Address;

class Attribute extends \Magento\Framework\View\Element\Template
{
public $collectionFactory;
public $bhartendukumarHelper;

public function __construct(
\Magento\Framework\View\Element\Template\Context $context,
\Magento\Customer\Model\ResourceModel\Address\Attribute\CollectionFactory $collectionFactory,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper,
array $data = []
) {
parent::__construct($context, $data);

$this->collectionFactory = $collectionFactory;
$this->bhartendukumarHelper = $bhartendukumarHelper;
}

public function getCollection()
{
$collection = $this->collectionFactory->create();
$collection->addFieldToFilter('is_user_defined', 1);
$collection->addFieldToFilter('is_visible', 1);
$collection->setOrder('sort_order', 'ASC');

if (!empty($collection)) {
$customer = $this->getCustomerData();
foreach ($collection as $key => $attribute) {
$attribute_id = $attribute->getAttributeId();
$used_in_forms = $this->getUsedInForms($attribute_id);

if ($customer === null) {
if (!in_array('customer_register_address', $used_in_forms)) {
$collection->removeItemByKey($key);
}
} elseif ($customer !== null) {
if (!in_array('customer_address_edit', $used_in_forms)) {
$collection->removeItemByKey($key);
}
}
}
}

return $collection;
}

public function getSelectOptionValues($attribute_id)
{
return $this->bhartendukumarHelper->getSelectOptionValues($attribute_id, $this->getEntityTypeId());
}

public function getCustomerData()
{
$address_id = $this->getRequest()->getParam('id');
if (is_numeric($address_id)) {
return $this->bhartendukumarHelper->getCustomerData('customer_address', $address_id);
} else {
return null;
}
}

public function getUsedInForms($attribute_id)
{
return $this->bhartendukumarHelper->getUsedInForms($attribute_id, $this->getEntityTypeId());
}

public function getEntityTypeId()
{
$entity_type = \Magento\Customer\Api\AddressMetadataInterface::ENTITY_TYPE_ADDRESS;
return $this->bhartendukumarHelper->getEntityTypeId($entity_type);
}

public function getYesNo()
{
return $this->bhartendukumarHelper->getYesNo();
}
}
