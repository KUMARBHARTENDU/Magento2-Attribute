<?php

namespace Bhartendukumar\Attribute\Observer;

use Magento\Framework\Event\ObserverInterface;

class CategoryAttributeAddUpdateAfter implements ObserverInterface
{
private $collectionFactory;
private $directoryList;
private $objOptions;
private $catalogEavAttribute;
private $bhartendukumarHelper;
private $fileSystem;

public function __construct(
\Magento\Catalog\Model\ResourceModel\Category\Attribute\CollectionFactory $collectionFactory,
\Magento\Framework\App\Filesystem\DirectoryList $directoryList,
\Magento\Eav\Block\Adminhtml\Attribute\Edit\Options\Options $objOptions,
\Magento\Catalog\Model\ResourceModel\Eav\Attribute $catalogEavAttribute,
\Magento\Framework\Filesystem\Driver\File $fileSystem,
\Bhartendukumar\Attribute\Helper\Data $bhartendukumarHelper
) {
$this->collectionFactory = $collectionFactory;
$this->directoryList = $directoryList;
$this->objOptions = $objOptions;
$this->catalogEavAttribute = $catalogEavAttribute;
$this->fileSystem = $fileSystem;
$this->bhartendukumarHelper = $bhartendukumarHelper;
}

public function execute(\Magento\Framework\Event\Observer $observer)
{
$root_path = $this->directoryList->getRoot();

$collection = $this->collectionFactory->create();
$collection->addFieldToFilter('is_user_defined', 1);
$collection->setOrder('main_table.attribute_id', 'ASC');

$file = $root_path.'/app/code/Bhartendukumar/Attribute/view/adminhtml/ui_component/category_form.xml';
if (!$this->fileSystem->isExists($file)) {
$file = $root_path.'/vendor/bhartendukumar/attribute/view/adminhtml/ui_component/category_form.xml';
}

if ($this->fileSystem->isExists($file)) {
$attribute_xml = $this->getAttributeXml($collection);

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<form xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Ui:etc/ui_configuration.xsd">
<fieldset name="bhartendukumar_custom_attributes">
<argument name="data" xsi:type="array">
<item name="config" xsi:type="array">
<item name="label" xsi:type="string" translate="true">Custom Attributes (BHARTENDUKUMAR)</item>
<item name="collapsible" xsi:type="boolean">true</item>
<item name="sortOrder" xsi:type="number">1</item>
</item>
</argument>'.$attribute_xml.'
	</fieldset>
</form>
';
//write file
$this->fileSystem->filePutContents($file, $xml);

//clean the cache
$this->bhartendukumarHelper->cleanBackendCache();
}
}

private function getAttributeXml($collection)
{
$sortOrder = 1;
$attr_xml = '';
foreach ($collection as $attribute) {
$is_required = 'false';
if ($attribute->getIsRequired()) {
$is_required = 'true';
}

$attribute_id = $attribute->getAttributeId();
$attribute_code = $attribute->getAttributeCode();
$label = $attribute->getFrontendLabel();
$default_value = $attribute->getDefaultValue();
$source_model = $attribute->getSourceModel();
$frontend_input = $attribute->getFrontendInput();
$frontend_class = $attribute->getFrontendClass();

$frontend_class_xml = '';
if ($frontend_class) {
$frontend_class_xml = "\n\t\t\t\t\t\t";
$frontend_class_xml.= '<item name="'.$frontend_class.'" xsi:type="boolean">true</item>';
}

if ($source_model == 'Magento\Eav\Model\Entity\Attribute\Source\Boolean') {
$attr_xml.= "\n\t\t".'<field name="'.$attribute_code.'">
<argument name="data" xsi:type="array">
<item name="config" xsi:type="array">
<item name="sortOrder" xsi:type="number">'.$sortOrder.'</item>
<item name="dataType" xsi:type="string">boolean</item>
<item name="formElement" xsi:type="string">checkbox</item>
<item name="source" xsi:type="string">category</item>
<item name="prefer" xsi:type="string">toggle</item>
<item name="label" xsi:type="string" translate="true">'.$label.'</item>
<item name="valueMap" xsi:type="array">
<item name="true" xsi:type="string">1</item>
<item name="false" xsi:type="string">0</item>
</item>
<item name="validation" xsi:type="array">
<item name="required-entry" xsi:type="boolean">'.$is_required.'</item>
</item>
<item name="default" xsi:type="string">'.$default_value.'</item>
</item>
</argument>
</field>';
} elseif ($frontend_input == 'text' || $frontend_input == 'textarea' || $frontend_input == 'date') {
$formElement = 'input';
$additionalClasses = '';

if ($frontend_input == 'textarea') {
$formElement = 'textarea';
} elseif ($frontend_input == 'date') {
$formElement = 'date';
$additionalClasses = 'admin__field-date';
if ($default_value) {
$default_value = date("y-m-d", strtotime($default_value));
}
}

$attr_xml.= "\n\t\t".'<field name="'.$attribute_code.'">
<argument name="data" xsi:type="array">
<item name="config" xsi:type="array">
<item name="sortOrder" xsi:type="number">'.$sortOrder.'</item>
<item name="dataType" xsi:type="string">string</item>
<item name="formElement" xsi:type="string">'.$formElement.'</item>
<item name="label" xsi:type="string" translate="true">'.$label.'</item>
<item name="validation" xsi:type="array">
<item name="required-entry" xsi:type="boolean">'.$is_required.'</item>'.$frontend_class_xml.'
</item>
<item name="default" xsi:type="string">'.$default_value.'</item>
<item name="additionalClasses" xsi:type="string">'.$additionalClasses.'</item>
</item>
</argument>
</field>';
} elseif ($frontend_input == 'select' || $frontend_input == 'multiselect') {
$options = $this->getSelectOptionValues($attribute_id);
$attr_xml.= "\n\t\t".'<field name="'.$attribute_code.'">
<argument name="data" xsi:type="array">
<item name="config" xsi:type="array">
<item name="sortOrder" xsi:type="number">'.$sortOrder.'</item>
<item name="dataType" xsi:type="string">string</item>
<item name="formElement" xsi:type="string">'.$frontend_input.'</item>
<item name="label" xsi:type="string" translate="true">'.$label.'</item>
<item name="validation" xsi:type="array">
<item name="required-entry" xsi:type="boolean">'.$is_required.'</item>
</item>
<item name="default" xsi:type="string">'.$default_value.'</item>
</item>
<item name="options" xsi:type="array">
'.$options.'
</item>
</argument>
</field>';
}

$sortOrder++;
}

return $attr_xml;
}

private function getEntityTypeId()
{
return $this->bhartendukumarHelper->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
}

private function getSelectOptionValues($attribute_id)
{
$option_xml = '';
if ($attribute_id) {
$this->bhartendukumarHelper->getCoreRegistry()->unregister('entity_attribute');
$this->objOptions->setData('option_values', null);
$this->objOptions->setData('store_option_values_0', null);
$model = $this->catalogEavAttribute->setEntityTypeId($this->getEntityTypeId());
$model->load($attribute_id);
$this->bhartendukumarHelper->getCoreRegistry()->register('entity_attribute', $model);

$option_values = $this->objOptions->getOptionValues();
if (!empty($option_values)) {
foreach ($option_values as $key => $val) {
$option_xml.='<item name="'.$key.'" xsi:type="array">
<item name="label" xsi:type="string">'.$val['store0'].'</item>
<item name="value" xsi:type="string">'.$val['id'].'</item>
</item>';
}
}
}
return $option_xml;
}
}
