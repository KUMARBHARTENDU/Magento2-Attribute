<?php

namespace Bhartendukumar\Attribute\Block\Adminhtml\Category\Attribute\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
public function _construct()
{
parent::_construct();
$this->setId('attribute_tabs');
$this->setDestElementId('edit_form');
$this->setTitle(__('Attribute Information'));
}
public function _beforeToHtml()
{
$this->addTab(
'main',
[
'label' => __('Properties'),
'title' => __('Properties'),
'content' => $this->getChildHtml('main'),
'active' => true
]
);
return parent::_beforeToHtml();
}
}
