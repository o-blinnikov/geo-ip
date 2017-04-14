(function($) {

    $.fn.geoip = function() {
        var popup = $(this);
        var targetUrl = '';

        var updateTargetUrl = function(option) {
            var url = option.data('url');
            targetUrl = url;
        };

        var updateFlag = function(option) {
            var country = option.data('flag');
            var flag = popup.find('.flag-icon');
            flag.removeClass();
            if (country) {
                flag.addClass('flag-icon flag-icon-' + country.toLowerCase());
            }
        };

        var updateCurrency = function(option) {
            var currencyContainer = popup.find('#geoIpCurrency');
            var currency = option.data('currency');
            currencyContainer.html(currency);
        };

        popup.find('.cancel').on('click', function() {
            popup.hide();
        });

        popup.find('.proceed').on('click', function() {
            Mage.Cookies.set('geoip', true);
            window.location.href = targetUrl;
        });

        popup.find('.geoip-country-select').on('change', function() {
            var selected = $(this).find(':selected');
            updateTargetUrl(selected);
            updateFlag(selected);
            updateCurrency(selected);
        });

        popup.show();
        popup.find('.geoip-country-select').trigger('change');
    };

    $(function() {
        var popup = $('#geoIpModal');
        popup.modal();
        popup.geoip();
    });

})(jQuery);