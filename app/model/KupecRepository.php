<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'kupci'.
 */
class KupecRepository extends Repository
{

  protected $table = 'kupci';

  /**
   * @return array
   */
  public function seznamKupcu()
  {
    return $this->findAll()->order('jmeno')->fetchPairs('jmeno', 'prijmeni');
  }

  /**
   * Kupci s dluhem.
   * @return array
   */
  public function seznamDluzniku()
  {
    return $this->findAll()->where('jmeno <> "DHE"')->where('dluh > 0')->order('jmeno')->fetchPairs('jmeno', 'dluh');
  }

  /**
   * @return int
   */
  public function zaokrouhliDluh($castka)
  {
    return $castka;
  }

  public function splatkaDluhu($kupec, $castka)
  {
    $castka = max(0, intval($castka));
    if($castka > 0) {
      $kupec->update(array(
        "dluh" => max(0, $kupec->dluh - $castka),
        "zaplaceno" => $castka,
        "datum_platby" => date('Y-m-d H:i:s')
      ));
    }
    return $castka;
  }
}
