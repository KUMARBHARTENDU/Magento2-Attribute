
require(["jquery","mage/calendar"], function ($) {
$(document).ready(function () {
/*customer
if (!$('fieldset[class="fieldset create account"]').length && $('#password').length) {
var base_url = window.authenticationPopup.baseUrl;

$.ajax({
type : 'POST',
url: base_url + 'pbam/account/edit',
data : '',
async : false,
success: function (result) {
if (result.html_data) {
$('fieldset[class="fieldset password"]').after(result.html_data);
}
}
});
}

/*customer address
if ($('fieldset[class="fieldset address"]').length || $('form[class="form-address-edit"]').length) {
var base_url = window.authenticationPopup.baseUrl;
var extra = '';

if ($('form[class="form-address-edit"]').length) {
var aid = $('form[class="form-address-edit"]').attr('action').split('/');
var akey = aid.length - 2;
aid = aid[akey];

extra = '/id/' + aid;
}

$.ajax({
type : 'POST',
url: base_url + 'pbam/address/edit' + extra,
data : '',
async : false,
success: function (result) {
if (result.html_data) {
if ($('fieldset[class="fieldset address"]').length) {
$('fieldset[class="fieldset address"]').append(result.html_data);
} else if ($('form[class="form-address-edit"]').length) {
$('div[class="field country required"]').after(result.html_data);
}
}
}
});
}

$('input[data-attr="date"]').calendar();
});
});
