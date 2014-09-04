<?php

namespace App\Presenters;

use App\Model\NanukRepository,
    App\Model\MrazakRepository,
    App\Model\KupecRepository,
    Nette\Application\UI\Form,
    Nextras\Forms\Rendering\Bs3FormRenderer,
    NanukyException;


/**
 * Mrazak presenter.
 */
final class MrazakPresenter extends BasePresenter
{
  
  /**
   * @var MrazakRepository
   * @inject
   */
  public $mrazak;

  /**
   * @var NanukRepository
   * @inject
   */
  public $nanuk;

  /**
   * @var KupecRepository
   * @inject
   */
  public $kupec;

  public function beforeRender()
  {
    $this->template->uziv = null;
  }

  /**
   * @param string kupec
   */
  public function renderDefault()
  {
    $this->template->seznamKupcu = $this->kupec->seznamKupcu();
  }

  public function renderNabidka($uziv)
  {
    $kupec = $this->kupec->get(strtoupper($uziv));
    $this->template->uziv = $kupec;
    $this->template->dluh = $kupec ? $this->kupec->zaokrouhliDluh($kupec->dluh) : 0;
    $this->template->nanuky = $this->mrazak->inventura();
    $this->template->ceny = $this->mrazak->cenik();
    $this->template->oblibene = $this->mrazak->oblibene($uziv);
  }

  public function renderPridat()
  {
    $this->template->velikostBaleni = $this->nanuk->findAll()->fetchPairs('id', 'baleni');
  }

  public function renderDluhy()
  {
    $kupci = $this->kupec->findAll()->order('jmeno');
    $this->template->kupci = array();
    foreach ($kupci as $kupec) {
      $this->template->kupci[$kupec->jmeno] = $this->kupec->zaokrouhliDluh($kupec->dluh);
    }
  }

  public function renderNakupy()
  {
    $this->template->nakupy = $this->mrazak->posledniNakupy();
  }

  /**
   * @param int druh nanuku
   * @param string kupec
   */
  public function handleNakup($nanuk, $kupec)
  {
    $konkretniKus = $this->mrazak->volnyNanuk($nanuk);

    if($konkretniKus) {
      try {
        if($kupec) {
          $this->koupitNanuk($konkretniKus->id, $kupec);
          $this->flashMessage('Zakoupen nanuk ' . $konkretniKus->nazev . ' za ' . $konkretniKus->cena . ' Kč', 'success');
        }
        else {
          $this->odepsatNanuk($konkretniKus->id);
          $this->flashMessage('Odepsán nanuk ' . $konkretniKus->nazev . ' za ' . $konkretniKus->cena . ' Kč', 'success');
        }
      }
      catch(NanukyException $e) {
        $this->flashMessage($e->getMessage(), 'danger');
      }
    }
    else {
      $this->flashMessage('Jdeš pozdě! Tento nanuk už na mražáku není.', 'warning');
    }

    if ($this->isAjax()) {
      $this->invalidateControl('mrazak');
      $this->invalidateControl('dluh');
      $this->invalidateControl('flash');
    }
  }

  /**
   * @param string kupec
   */
  public function handleDluh($kupec)
  {
    $uziv = $this->kupec->get($kupec);
    $castka = $this->kupec->zaokrouhliDluh($uziv->dluh);
    $uziv->update(array(
      "dluh" => 0,
      "zaplaceno" => $uziv->zaplaceno + $castka
    ));
    $this->flashMessage($uziv->jmeno. ' splatil svůj dluh ' . $castka . ' Kč', 'success');
    if ($this->isAjax()) {
      $this->invalidateControl('dluznici');
      $this->invalidateControl('flash');
    }
  }

  /**
   * @param int ID nakupu
   */
  public function handleStorno($id)
  {
    $this->zrusitNakup($id);
    $nakup = $this->mrazak->get($id);

    $this->flashMessage('Nákup byl zrušen.', 'success');
    if ($this->isAjax()) {
      $this->invalidateControl('nakupy');
      $this->invalidateControl('flash');
    }
  }
  
  /**
   * Formulář pro přidání nanuku na mražák
   * @return Form
   */
  protected function createComponentNanukForm()
  {
    $form = new Form;

    $form->addText('cena', 'Cena balení')
      ->setRequired('Zadej nákupní cenu celého balení.');
    $form->addSelect('nanuky_id', 'Nanuk', $this->nanuk->seznamNanuku())
      ->setRequired('Vyber druh nanuku.')
      ->setPrompt('Vyber nanuk');
    $form->addText('pocet', 'Počet v balení')
      ->setRequired('Zadej počet nanuků v balení.');
    $form->addText('cena_nakup', 'Nákupní cena [kus]')
      ->setRequired('Zadej nákupní cenu jednoho nanuku.');
    $form->addText('cena_prodej', 'Prodejní cena [kus]')
      ->setRequired('Zadej prodejní cenu jednoho nanuku.');
    $form->addSubmit('ok', 'Přidat');

    $form->onSuccess[] = $this->nanukFormSuccess;

    $form->setRenderer(new Bs3FormRenderer);

    return $form;
  }


  /**
   * Zpracování formuláře pro přidání nanuku do mražáku
   * @param Form $form
   */
  public function nanukFormSuccess($form)
  {
    $this->naskladnit($form->getValues());

    $this->flashMessage('Přidáno', 'success');
    $this->redirect('pridat');
  }


  /**
   * Fasáda pro přidání nanuků na sklad
   * @param $values[]
   */
  private function naskladnit($values)
  {
    $pocet = $values['pocet'];
    unset($values['pocet']);
    unset($values['cena']);
    $data = array();

    for($i=0; $i<$pocet; $i++) {
      $data[] = $values;
    }
    if(count($data)) $this->mrazak->insert($data);
  }

  /**
   * Fasáda pro zakoupení nanuku
   * @param int druh nanuku
   * @param string jméno kupce
   */
  private function koupitNanuk($mrazakId, $jmeno)
  {
    $nakup = $this->mrazak->get($mrazakId);
    $kupec = $this->kupec->get($jmeno);

    if(!$kupec) throw new NanukyException('Žádný zákazník se jménem "' . $jmeno . '" neexistuje.');

    $dataNakup = array(
      'kupec' => $jmeno,
      'datum_nakupu' => date('Y-m-d H:i:s')
    );
    $dataKupec = array(
      'dluh' => $kupec->dluh + $nakup->cena_prodej
    );

    try {
      $this->mrazak->beginTransaction();
      $nakup->update($dataNakup);
      $kupec->update($dataKupec);
      $this->mrazak->commitTransaction();
    }
    catch(\PDOException $e) {
      $this->mrazak->rollbackTransaction();
      throw new NanukyException('Chybička se vloudila. Nákup se nepodařil.');
    }
  }

  /**
   * Fasáda pro odepsání nanuku
   * @param int druh nanuku
   */
  private function odepsatNanuk($mrazakId)
  {
    $nakup = $this->mrazak->get($mrazakId);

    $dataNakup = array(
      'kupec' => null,
      'datum_nakupu' => date('Y-m-d H:i:s')
    );

    try {
      $nakup->update($dataNakup);
    }
    catch(\PDOException $e) {
      throw new NanukyException('Chybička se vloudila. Nákup se nepodařil.');
    }
  }

  /**
   * Fasáda pro zrušení nákupu
   * @param int
   */
  private function zrusitNakup($id)
  {
    $nakup = $this->mrazak->get($id);
    $kupec = $this->kupec->get($nakup->kupec);

    $nakup->update(array('kupec' => null, 'datum_nakupu' => null));
    if($kupec) $kupec->update(array('dluh' => $kupec->dluh - $nakup->cena_prodej));
  }
}
