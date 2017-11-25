<?php

namespace Bhartendukumar\Attribute\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
public $groupCollectionFactory;
public $eavEntity;
public $coreRegistry;
public $validatorFactory;
public $productHelper;
public $categoryModel;
public $cacheFrontendPool;
public $yesNo;
public $customerAttributeModel;
public $customerSession;
public $addressRepository;
public $objOptions;
public $storeManager;

public function __construct(
\Magento\Framework\App\Helper\Context $context,
\Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\CollectionFactory $groupCollectionFactory,
\Magento\Eav\Model\Entity $eavEntity,
\Magento\Framework\Registry $coreRegistry,
\Magento\Eav\Model\Adminhtml\System\Config\Source\Inputtype\ValidatorFactory $validatorFactory,
\Magento\Catalog\Helper\Product $productHelper,
\Magento\Catalog\Model\Category $categoryModel,
\Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
\Magento\Config\Model\Config\Source\Yesno $yesNo,
\Magento\Customer\Model\Attribute $customerAttributeModel,
\Magento\Customer\Model\Session $customerSession,
\Magento\Customer\Api\AddressRepositoryInterface $addressRepository,
\Magento\Eav\Block\Adminhtml\Attribute\Edit\Options\Options $objOptions,
\Magento\Store\Model\StoreManagerInterface $storeManager
) {
parent::__construct($context);

$this->groupCollectionFactory = $groupCollectionFactory;
$this->eavEntity = $eavEntity;
$this->coreRegistry = $coreRegistry;
$this->validatorFactory = $validatorFactory;
$this->productHelper = $productHelper;
$this->categoryModel = $categoryModel;
$this->cacheFrontendPool = $cacheFrontendPool;
$this->yesNo = $yesNo;
$this->customerAttributeModel = $customerAttributeModel;
$this->customerSession = $customerSession;
$this->addressRepository = $addressRepository;
$this->objOptions = $objOptions;
$this->storeManager = $storeManager;
}

public function getDefaultAttributeGroupId($attributeSetId)
{
$groupCollection = $this->groupCollectionFactory->create()
->setAttributeSetFilter($attributeSetId)
->addFieldToFilter('default_id', '1')
->setPageSize(1)
->load();
$group = $groupCollection->getFirstItem();
return $group->getId();
}

public function getEntityTypeId($type)
{
return $this->eavEntity->setType($type)->getTypeId();
}

public function getCoreRegistry()
{
return $this->coreRegistry;
}

public function getValidatorFactory()
{
return $this->validatorFactory;
}

public function getProductHelper()
{
return $this->productHelper;
}

public function getCategoryModel()
{
return $this->categoryModel;
}

public function cleanBackendCache()
{
foreach ($this->cacheFrontendPool as $cacheFrontend) {
$cacheFrontend->getBackend()->clean();
}
}

public function getYesNo()
{
return $this->yesNo->toOptionArray();
}

public function getUsedInForms($attribute_id, $entityTypeId)
{
if ($attribute_id) {
$model = $this->customerAttributeModel->setEntityTypeId($entityTypeId);
$model->load($attribute_id);

return $model->getUsedInForms();
}
return null;
}

public function getCustomerData($type, $address_id = null)
{
$customerData = $this->customerSession;
if ($customerData->isLoggedIn()) {
if ($type == 'customer') {
return $customerData->getCustomer();
} elseif ($type == 'customer_address') {
if ($address_id !== null) {
return $this->addressRepository->getById($address_id);
}
}
}
return null;
}

public function getSelectOptionValues($attribute_id, $entityTypeId)
{
if ($attribute_id) {
$this->coreRegistry->unregister('entity_attribute');
$this->objOptions->setData('option_values', null);

foreach ($this->objOptions->getStores() as $store) {
$storeId = $store->getId();
$this->objOptions->setData('store_option_values_'.$storeId, null);
}
$model = $this->customerAttributeModel->setEntityTypeId($entityTypeId);
$model->load($attribute_id);
$this->coreRegistry->register('entity_attribute', $model);

$curr_store_id = $this->getCurrentStoreId();
$option_values = $this->objOptions->getOptionValues();
if ($curr_store_id != 0) {
foreach ($option_values as $key => $val) {
if ($val['store'.$curr_store_id] != '') {
$option_values[$key]['store0'] = $val['store'.$curr_store_id];
}
}
}

return $option_values;
}
return null;
}

public function modifySelectOptionValues($data)
{
if (isset($data['option']['value'])) {
foreach ($data['option']['value'] as $key => $val) {
if ($val[0] == '') {
foreach ($val as $admin_key => $admin_value) {
if ($admin_key != 0 && $admin_value != '') {
$data['option']['value'][$key][0] = $admin_value;
break;
}
}
}
}
}

return $data;
}

public function getCurrentStoreId()
{
return $this->storeManager->getStore()->getStoreId();
}

public function checkIsBoolean($model, $attributeId, $frontend_input)
{
if (!$attributeId && $frontend_input == 'boolean') {
$model->setData('frontend_input', 'select');
$model->save();
}
}
}
