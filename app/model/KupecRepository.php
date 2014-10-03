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
}
