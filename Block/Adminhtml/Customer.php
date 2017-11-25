<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml;

class Customer extends \Magento\Backend\Block\Widget\Grid\Container
{
public function _construct()
{
$this->_blockGroup = 'Bhartendukumar_Attribute';
$this->_controller = 'adminhtml_customer';
$this->_headerText = __('Customer Attribute');
$this->_addButtonLabel = __('Add New Attribute');
parent::_construct();
}
}
