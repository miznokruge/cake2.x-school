var url_contact = "<?php echo $this->webroot . 'SalesContacts/getcount'; ?>";
function getSalesContact() {
$.get(url_contact, function(data) {
$('#contact_pad').html(data);
});
};
getSalesContact();
setInterval(function() {
getSalesContact();
}, 5000);