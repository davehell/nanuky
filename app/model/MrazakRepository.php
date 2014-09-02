<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'Sklad'.
 */
class MrazakRepository extends Repository
{

  protected $table = 'mrazak';

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

  /**
   * Poslední nákupy
   * @return \Nette\Database\Table\Selection
   */
  public function posledniNakupy()
  {
    return $this->findAll()->where('datum IS NOT NULL')->order('datum DESC')->limit(20);
  }

  /**
   * Kupcovy oblíbené nanuky
   * @param string
   * @return array
   */
  public function oblibene($kupec)
  {
    if(!$kupec) return array();
    $nanuky = $this->findAll()->select('nanuky_id AS id, count(nanuky_id) AS obliba')->where('kupec=?', $kupec)->group('nanuky_id')->order('obliba DESC')->limit(2);
    $oblibene = array();
    foreach($nanuky as $nanuk) {
      $oblibene[] = $nanuk->id;
    }
    return $oblibene;
  }
}
