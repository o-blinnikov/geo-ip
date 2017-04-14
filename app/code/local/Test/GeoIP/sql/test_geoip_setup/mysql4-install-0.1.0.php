<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$stores = array('uk' => 'UK',
                'eu' => 'EU');

//Switch to admin store (in order to successfully save a category)
$originalStoreId = Mage::app()->getStore()->getId();
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

//Allow to change Base Currency per Website
Mage::getConfig()->saveConfig('catalog/price/scope', 1, 'default', Mage_Core_Model_App::ADMIN_STORE_ID);

//Set allowed currencies
Mage::getConfig()->saveConfig('currency/options/allow', "USD,GBP,EUR", 'default', Mage_Core_Model_App::ADMIN_STORE_ID);

foreach ($stores as $k => $val) {

    /** @var $rootCategory Mage_Catalog_Model_Category */
    $rootCategory = Mage::getModel('catalog/category');
    $rootCategory->setName($val . ' Root Category')
        ->setPath('1')
        ->setStoreId(Mage_Core_Model_App::ADMIN_STORE_ID)
        ->save();

    /** @var $website Mage_Core_Model_Website */
    $website = Mage::getModel('core/website');
    $website->setCode($k)
        ->setName($val . ' Website')
        ->save();

    /** @var $storeGroup Mage_Core_Model_Store_Group */
    $storeGroup = Mage::getModel('core/store_group');
    $storeGroup->setWebsiteId($website->getId())
        ->setName($val. ' Website Store')
        ->setRootCategoryId($rootCategory->getId())
        ->save();

    /** @var $store Mage_Core_Model_Store */
    $store = Mage::getModel('core/store');
    $store->setCode($k . '_default')
        ->setWebsiteId($storeGroup->getWebsiteId())
        ->setGroupId($storeGroup->getId())
        ->setName($val. ' Store View')
        ->setIsActive(1)
        ->save();

    //Set currencies per Website
    if ($k == 'uk') {
        Mage::getConfig()->saveConfig('currency/options/base', "GBP", 'websites', $website->getId());
        Mage::getConfig()->saveConfig('currency/options/default', "GBP", 'websites', $website->getId());
    } else if ($k == 'eu') {
        Mage::getConfig()->saveConfig('currency/options/base', "EUR", 'websites', $website->getId());
        Mage::getConfig()->saveConfig('currency/options/default', "EUR", 'websites', $website->getId());
    }

}

//Set store to original value
Mage::app()->setCurrentStore($originalStoreId);

/**
 * Set default website
 */

$defaultWebsite = Mage::app()->getWebsite(1);
$defaultWebsite->setName('US Website')->save();
$defaultWebsite->getDefaultGroup()->setName('US Website Store')->save();

Mage::getConfig()->saveConfig('currency/options/base', "USD", 'websites', 1);
Mage::getConfig()->saveConfig('currency/options/base', "USD", 'websites', 1);

/**
 * add test_geoip/popup block to white list
 */

$blockName = 'test_geoip/popup';

$this->getConnection()->insert(
    $this->getTable('admin/permission_block'),
    array('block_name' => $blockName, 'is_allowed' => 1)
);


$installer->endSetup();