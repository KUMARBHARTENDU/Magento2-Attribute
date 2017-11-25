<?php

namespace Bhartendukumar\Attribute\Model\Plugin;

class EavValidationRules
{
public function aroundBuild($subject, $proceed, $arguments, $data)
{
$result = $proceed($arguments, $data);
$frontend_class = $arguments->getFrontendClass();

if ($frontend_class != '') {
if (!in_array($frontend_class, array_keys($result))) {
$result = array_merge($result, [$frontend_class => true]);
}
}
return $result;
}
}
