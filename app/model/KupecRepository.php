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
    return $this->findAll()->fetchPairs('jmeno', 'jmeno');
  }
}
