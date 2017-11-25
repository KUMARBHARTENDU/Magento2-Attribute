<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Customer;

class Address extends \Magento\Backend\Block\Widget\Grid\Container
{
public function _construct()
{
$this->_blockGroup = 'Bhartendukumar_Attribute';
$this->_controller = 'adminhtml_customer_address';
$this->_headerText = __('Customer Address Attribute');
$this->_addButtonLabel = __('Add New Attribute');
parent::_construct();
}
}
