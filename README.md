# GeoIP Module. Store switcher based on customer location

## 1. Overview
GeoIP module which targets a user’s delivery address when they first visit the site.

##2. How it Works##
###2.1 Basic functionality###
When a user visits the site they see a modal popup allowing them to select their “Country for Delivery”. Once their preference is set and they are on the correct store, they will not see the modal popup again.
To aid the customer’s ability to recognize their country, a flag displayed next to the country selector field representing the currently selected country. If a customer selects a different country, the flag updated too.
Below the country selector field, the customer informed about which currency the store will use when they switch to the country selected above. When they change country, the currency also update. The currency should always represent the currency of the store they will be sent to.
Finally, when a customer sets their country, their preference set and they redirected to the correct store.
2.1. Magento Configuration
The module allows an admin user to map each Magento store to one or more countries in the system configuration. For example, admin is able to configure the module so that, given he is in Germany, then he will be redirected to the EU store but if he is in the UK he will be redirected to the UK Store.
 
##3. Specification##
###3.1. Magento###
For example, you can setup 3 stores in one Magento installation - US, UK and EU websites.
1. The EU website can be setup to deliver to all EU countries and its currency is Euro.
2. The UK website can be setup to deliver only deliver to the UK and its currency is Sterling.
3. The US website can be setup to deliver to everywhere else and its currency is US Dollar.

The US could be the main store and the UK and EU could be /uk and /eu.

Finally this is built using the latest version of Magento (1.9.x) with the RWD theme and only used the <a href="https://github.com/magento-hackathon/Sandfox_GeoIP">Sandfox module</a>.

###3.2. Module###
This module was built with best practices and used the <a href="https://github.com/magento-ecg/coding-standard">ECG coding standard</a>. The  Sandfox GeoIP  module is used to figure out which country the User’s IP is from. It connects <a href="https://www.maxmind.com/">MaxMind’s</a> GeoIP Lite database to Magento. You will need to sync the IP’s when you install the module.

For creating the modal there is used <a href="http://getbootstrap.com/javascript/">Twitter Bootstrap’s Modal Javascript</a>. Also <a href="http://flag-icon-css.lip.is">Flag Icon CSS</a> is used for the flags.
