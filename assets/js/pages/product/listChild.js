let nbRegistration = $('#countRegistration').val();
let priceProduct = $('#totalPriceProduct').val();
let nbTotalSessions = $('#nbTotalSessions').val();
let total = parseInt(nbRegistration)*parseInt(priceProduct);

$('#nbRegistration').text(nbRegistration);
$('#showTotalPriceTtc').text(total);
$('#showTotalSessions').text(nbTotalSessions);
