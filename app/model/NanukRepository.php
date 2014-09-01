<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'nanuky'.
 */
class NanukRepository extends Repository
{

  protected $table = 'nanuky';

  /**
   * @return array
   */
  public function seznamNanuku()
  {
    return $this->findAll()->order('nazev')->fetchPairs('id', 'nazev');
  }
}
