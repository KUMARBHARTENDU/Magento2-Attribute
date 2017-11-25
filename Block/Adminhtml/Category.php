<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml;

class Category extends \Magento\Backend\Block\Widget\Grid\Container
{
public function _construct()
{
$this->_blockGroup = 'Bhartendukumar_Attribute';
$this->_controller = 'adminhtml_category';
$this->_headerText = __('Category Attribute');
$this->_addButtonLabel = __('Add New Attribute');
parent::_construct();
}
}
