<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'Sklad'.
 */
class SkladRepository extends Repository
{

  protected $table = 'sklad';

  /**
   * @return \Nette\Database\Table\Selection
   */
  public function inventura()
  {
    return $this->database->query(
      'SELECT nanuky.nazev, count(nanuky_id) AS pocet,
      (SELECT cena_prodej FROM sklad s2 WHERE s1.nanuky_id = s2.nanuky_id AND s2.kupci_id IS NULL AND s2.cena_prodej > 0 ORDER BY id LIMIT 1) AS cena
      FROM sklad s1, nanuky
      WHERE s1.nanuky_id = nanuky.id
      AND s1.kupci_id IS NULL
      AND s1.cena_prodej > 0
      GROUP BY nanuky_id;'
    );
  }
}
