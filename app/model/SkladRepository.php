<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'Sklad'.
 */
class SkladRepository extends Repository
{

  protected $table = 'sklad';

  /**
   * Počty nanuků v mražáku.
   * @return \Nette\Database\Table\Selection
   */
  public function inventura()
  {
    return $this->database->table('volne_nanuky')->select('nanuky_id, nazev, count(nanuky_id) AS pocet')->group('nanuky_id');
  }
}
