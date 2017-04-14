<?php

/**
 * Class Test_GeoIP_Block_Popup
 */
class Test_GeoIP_Block_Popup extends Mage_Core_Block_Template
{
    /**
     * @return Mage_Core_Block_Abstract
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * returns countries, which can be switched on the frontend
     *
     * @return array
     */
    public function getSwitchableCountries()
    {
        $result = array();
        $allCountries = Mage::getResourceModel('directory/country_collection')
                        ->loadByStore()
                        ->toOptionArray(true);

        foreach ($allCountries as $country) {
            if (!empty($country['value'])) {
                $website_data = $this->getWebsiteData($country['value']);
                $country['currency'] = $website_data['currency'];
                $country['url'] = $website_data['url'];
                $result[] = $country;
            }
        }

        return $result;
    }

    /**
     * @param $countryCode
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getWebsiteData($countryCode)
    {
        $result = array();

        foreach (Mage::app()->getWebsites() as $website) {

            $website = Mage::app()->getWebsite($website->getId());

            $config_data = explode(',' , $website->getConfig('test_geoip/test_geoip_config/countries'));

            if (in_array($countryCode, $config_data)) {
                $result['currency'] = Mage::app()->getWebsite($website->getId())->getBaseCurrencyCode();
                $result['url'] = $website->getDefaultStore()->getBaseUrl();
                return $result;
            }
        }

        return $result;

    }
}