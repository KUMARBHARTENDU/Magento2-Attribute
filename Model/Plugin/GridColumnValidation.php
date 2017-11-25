<?php

namespace Bhartendukumar\Attribute\Model\Plugin;

class GridColumnValidation
{
public $entityAttribute;

public function __construct(
\Magento\Eav\Model\Entity\Attribute $entityAttribute
) {
$this->entityAttribute = $entityAttribute;
}

public function aroundCreate($subject, $proceed, $attributeData, $columnName, $context, $config)
{
$result = $proceed($attributeData, $columnName, $context, $config);

$attribute_code = $attributeData['attribute_code'];
$attribute = $this->entityAttribute->loadByCode('customer', $attribute_code);
$frontend_class = $attribute->getFrontendClass();

if (!$frontend_class && $attributeData['frontend_input'] == 'date') {
$frontend_class = 'validate-date';
}

if ($frontend_class) {
$config = $result->getConfiguration();
$validationRules = [$frontend_class => 1];
if (!empty($config['editor']['validation'])) {
$validationRules = array_merge($config['editor']['validation'], $validationRules);
}
$config['editor']['validation'] = $validationRules;
$result->setData('config', $config);
}

return $result;
}
}
