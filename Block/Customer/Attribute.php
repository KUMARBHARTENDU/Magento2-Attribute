<?php

namespace Bhartendukumar\Attribute\Block\Customer;

class Attribute extends \Magento\Framework\View\Element\Template
{
public $customerAttributeCollection;
public $bhartendukumarHelper;

public function __construct(
\Magento\Framework\View\Element\Template\Context $context,
\Magento\Customer\Model\ResourceModel\Attribute\CollectionFactory $customerAttributeCollection,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper,
array $data = []
) {
parent::__construct($context, $data);

$this->customerAttributeCollection = $customerAttributeCollection;
$this->bhartendukumarHelper = $bhartendukumarHelper;
}

public function getCollection()
{
$collection = $this->customerAttributeCollection->create();
$collection->addFieldToFilter('is_user_defined', 1);
$collection->addFieldToFilter('is_visible', 1);
$collection->setOrder('sort_order', 'ASC');

if (!empty($collection)) {
$customer = $this->getCustomerData();
foreach ($collection as $key => $attribute) {
$attribute_id = $attribute->getAttributeId();
$used_in_forms = $this->getUsedInForms($attribute_id);

if ($customer === null) {
if (!in_array('customer_account_create', $used_in_forms)) {
$collection->removeItemByKey($key);
}
} elseif ($customer !== null) {
if (!in_array('customer_account_edit', $used_in_forms)) {
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
return $this->bhartendukumarHelper->getCustomerData('customer');
}

public function getUsedInForms($attribute_id)
{
return $this->bhartendukumarHelper->getUsedInForms($attribute_id, $this->getEntityTypeId());
}

public function getEntityTypeId()
{
return $this->bhartendukumarHelper->getEntityTypeId(\Magento\Customer\Model\Customer::ENTITY);
}

public function getYesNo()
{
return $this->bhartendukumarHelper->getYesNo();
}
}
