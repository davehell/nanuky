$(function () {
$.nette.ext({
    load: function() {
      /**
       * Splacení dluhu zákazníka.
       */
      $('button.dluh').click(function (event) {
        var url = $(this).data('url');
        var jmeno = $(this).data('jmeno');
        var castka = $( "input#dluh-" + jmeno ).val();

        if(!castka) return;
        $.nette.ajax({url: url, data: {"castka": castka}}, event).done(function() {
        });
      });
    }
});
$.nette.init();
});

/**
 * Výpočet prodejní ceny jednoho nanuku na základě ceny celého balení.
 * @param  {int} pocetKusu počet kusů v balení
 */
function nastavCeny(pocetKusu) {
  var cenaBaleni = parseFloat(($( "#frm-nanukForm-cena" ).val()).replace(/,/g, "."));
  var cenaNakup = (cenaBaleni / pocetKusu).toFixed(2);
  var cenaProdej = Math.ceil(cenaNakup);
  $( "#frm-nanukForm-cena_nakup" ).val(cenaNakup);
  $( "#frm-nanukForm-cena_prodej" ).val(cenaProdej);
}

/**
 * Nastavení focusu na políčko s cenou balení.
 */
$( "#frm-nanukForm-cena" ).focus();

/**
 * Při změně ceny balení se vymažou ostatní políčka.
 */
$( "#frm-nanukForm-cena" ).change(function() {
  $( "#frm-nanukForm-pocet" ).val("");
  $( "#frm-nanukForm-cena_nakup" ).val("");
  $( "#frm-nanukForm-cena_prodej" ).val("");
});

/**
 * Při výběru druhu nanuku se aktualizuje prodejní cena.
 */
$( "#frm-nanukForm-nanuky_id" ).change(function() {
  var pocetKusu = velikostiBaleni[this.value];
  $( "#frm-nanukForm-pocet" ).val(pocetKusu);
  nastavCeny(pocetKusu);
});

/**
 * Při změně počtu kusů v balení se aktualizuje prodejní cena.
 */
$( "#frm-nanukForm-pocet" ).change(function() {
  var pocetKusu = $( this ).val();
  nastavCeny(pocetKusu);
});

