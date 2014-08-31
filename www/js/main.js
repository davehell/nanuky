$(function(){

});


$( "#frm-nanukForm-nanuky_id" ).change(function() {
  var pocet = velikostiBaleni[this.value];
  $( "#frm-nanukForm-pocet" ).val(pocet);
});

$( "#frm-nanukForm-cena" ).change(function() {
  var pocetKusu = $( "#frm-nanukForm-pocet" ).val();
  var cenaNakup = this.value / pocetKusu;
  cenaNakup = Math.ceil(cenaNakup * 10) / 10;
  var cenaProdej = Math.ceil(cenaNakup);
  $( "#frm-nanukForm-cena_nakup" ).val(cenaNakup);
  $( "#frm-nanukForm-cena_prodej" ).val(cenaProdej);
});
