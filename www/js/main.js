$(function(){
  $.nette.init();
});

$( "#frm-nanukForm-cena" ).focus();

$( "#frm-nanukForm-cena" ).change(function() {
  $( "#frm-nanukForm-pocet" ).val("");
  $( "#frm-nanukForm-cena_nakup" ).val("");
  $( "#frm-nanukForm-cena_prodej" ).val("");
});

$( "#frm-nanukForm-nanuky_id" ).change(function() {
  var cenaBaleni = parseFloat($( "#frm-nanukForm-cena" ).val());
  var pocetKusu = velikostiBaleni[this.value];
  var cenaNakup = (cenaBaleni / pocetKusu).toFixed(2);
  //cenaNakup = Math.ceil(cenaNakup * 10) / 10;
  var cenaProdej = Math.ceil(cenaNakup);
  $( "#frm-nanukForm-pocet" ).val(pocetKusu);
  $( "#frm-nanukForm-cena_nakup" ).val(cenaNakup);
  $( "#frm-nanukForm-cena_prodej" ).val(cenaProdej);
});

