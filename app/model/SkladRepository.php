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
    return $this->database->table('volne_nanuky')->select('nanuky_id, nazev, count(nanuky_id) AS pocet')->group('nanuky_id')->order('nazev');
  }

  /**
   * Ceny nanuků v mražáku.
   * @return \Nette\Database\Table\Selection
   */
  public function cenik()
  {
    return $this->database->table('volne_nanuky')->select('DISTINCT nanuky_id, cena')->order('id DESC');
  }

  /**
   * @param int druh nanuku
   * @return \Nette\Database\Table\ActiveRow|FALSE
   */
  public function volnyNanuk($id)
  {
    return $this->database->table('volne_nanuky')->where('nanuky_id=?', $id)->order('id')->fetch();
  }
}
