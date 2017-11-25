<?php

namespace Bhartendukumar\Attribute\Model\Plugin\Metadata;

class Form
{
public $request;
public $customerAddressAttributeCollection;

public function __construct(
\Magento\Framework\App\RequestInterface $request,
\Magento\Customer\Model\ResourceModel\Address\Attribute\CollectionFactory $customerAddressAttributeCollection
) {
$this->request = $request;
$this->customerAddressAttributeCollection = $customerAddressAttributeCollection;
}

public function aroundCompactData($subject, $proceed, $data)
{
$result = $proceed($data);

$addressCollection = $this->customerAddressAttributeCollection->create();
$addressCollection->addFieldToFilter('is_user_defined', 1);
foreach ($addressCollection as $key => $attribute) {
if ($this->request->getParam($attribute->getAttributeCode())) {
$result[$attribute->getAttributeCode()] = $this->request->getParam($attribute->getAttributeCode());
}
}

return $result;
}
}
