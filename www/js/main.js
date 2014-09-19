$(function(){
  $.nette.init();
});

$( "#frm-nanukForm-cena" ).focus();

$( "#frm-nanukForm-cena" ).change(function() {
  $( "#frm-nanukForm-pocet" ).val("");
  $( "#frm-nanukForm-cena_nakup" ).val("");
  $( "#frm-nanukForm-cena_prodej" ).val("");
});

function nastavCeny(pocetKusu) {
  var cenaBaleni = parseFloat(($( "#frm-nanukForm-cena" ).val()).replace(/,/g, "."));
  var cenaNakup = (cenaBaleni / pocetKusu).toFixed(2);
  var cenaProdej = Math.ceil(cenaNakup);
  $( "#frm-nanukForm-cena_nakup" ).val(cenaNakup);
  $( "#frm-nanukForm-cena_prodej" ).val(cenaProdej);
}

$( "#frm-nanukForm-nanuky_id" ).change(function() {
  var pocetKusu = velikostiBaleni[this.value];
  $( "#frm-nanukForm-pocet" ).val(pocetKusu);
  nastavCeny(pocetKusu);
});

$( "#frm-nanukForm-pocet" ).change(function() {
  var pocetKusu = $( this ).val();
  nastavCeny(pocetKusu);
});

