<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'Sklad'.
 */
class MrazakRepository extends Repository
{

  protected $table = 'mrazak';

  /**
   * Počty a názvy nanuků v mražáku.
   * @return \Nette\Database\Table\Selection
   */
  public function inventura()
  {
    return $this->findAll()->where('datum_nakupu IS NULL')->select('nanuky_id AS id, nanuky.nazev, count(nanuky_id) AS pocet')->group('nanuky_id')->order('nanuky.nazev');
  }

  /**
   * Přehled odepsaných nanuků
   * @return \Nette\Database\Table\Selection
   */
  public function odepsane()
  {
    return $this->findAll()->where('kupec IS NULL')->where('datum_nakupu IS NOT NULL')->select('nanuky.nazev')->order('datum_nakupu');
  }

  /**
   * Ceny nanuků v mražáku.
   * @return array
   */
  public function cenik()
  {
    return $this->findAll()->where('datum_nakupu IS NULL')->select('DISTINCT nanuky_id AS id, cena_prodej AS cena')->order('id DESC')->fetchPairs('id', 'cena');
  }

  /**
   * První dostupný nanuk daného druhu, který je v mražáku.
   * @param int druh nanuku
   * @return \Nette\Database\Table\ActiveRow|FALSE
   */
  public function volnyNanuk($id)
  {
    return $this->findAll()->select('mrazak.id, nanuky.nazev, cena_prodej AS cena')->where('datum_nakupu IS NULL')->where('nanuky_id=?', $id)->order('mrazak.id')->fetch();
  }

  /**
   * Poslední nákupy
   * @return \Nette\Database\Table\Selection
   */
  public function posledniNakupy($kupec = null)
  {
    $nakupy = $this->findAll()->where('datum_nakupu IS NOT NULL')->order('datum_nakupu DESC');
    if($kupec != null) {
      $nakupy = $nakupy->where('kupec = ?', strtoupper($kupec));
    }
    else {
      $nakupy = $nakupy->limit(50);
    }
    return $nakupy;
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
