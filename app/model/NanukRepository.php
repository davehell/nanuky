<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'nanuky'.
 */
class NanukRepository extends Repository
{

  protected $table = 'nanuky';

  /**
   * @return \Nette\Database\Table\Selection
   */
  public function seznamNanuku()
  {
    return $this->findAll()->order('nazev')->fetchPairs('id', 'nazev');
  }
}
