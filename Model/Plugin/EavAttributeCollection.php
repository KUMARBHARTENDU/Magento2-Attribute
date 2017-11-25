<?php

namespace Bhartendukumar\Attribute\Model\Plugin;

class EavAttributeCollection
{
public $productMetadata;

public function __construct(
\Magento\Framework\App\ProductMetadataInterface $productMetadata
) {
$this->productMetadata = $productMetadata;
}

public function afterGetAttributeCollection($subject, $result)
{
$version = $this->productMetadata->getVersion();
foreach ($result as $attribute) {
if ($attribute->getIsUserDefined() == 1) {
$attribute->setIsVisible(1);
//change for default value issue for date type attribute
if (version_compare($version, '2.1.0', '>=')) {
if ($attribute->getFrontendInput() == "date") {
$default_value = $attribute->getDefaultValue();
if ($default_value != "") {
$default_value = explode("/", $default_value);
$default_value = $default_value[2]."/".$default_value[0]."/".$default_value[1];
$attribute->setDefaultValue($default_value);
}
}
}
//end
}
}

return $result;
}
}
