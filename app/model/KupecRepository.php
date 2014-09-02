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
    return $this->findAll()->order('jmeno')->fetchPairs('jmeno', 'jmeno');
  }

  /**
   * @return int
   */
  public function zaokrouhliDluh($castka)
  {
    for($i = 1, $c = ceil($castka/5); $i <= $c; $i++) {
      $castka = $i * 5;
    }
    return $castka;
  }
}
