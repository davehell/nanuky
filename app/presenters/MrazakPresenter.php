<?php

namespace App\Presenters;

use App\Model\NanukRepository,
    App\Model\MrazakRepository,
    App\Model\KupecRepository,
    Nette\Application\UI\Form,
    Nextras\Forms\Rendering\Bs3FormRenderer;


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

  /**
   * @param string kupec
   */
  public function renderDefault($uziv = null)
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
    $mrazak = $this->mrazak->volnyNanuk($nanuk);
    $this->koupitNanuk($mrazak->id, $kupec);

    $this->flashMessage('Zakoupen nanuk ' . $mrazak->nazev . ' za ' . $mrazak->cena . ' Kč', 'success');
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
   * @param string
   * @param int
   */
  private function koupitNanuk($mrazakId, $jmeno = null)
  {
    $nakup = $this->mrazak->get($mrazakId);
    $dataNakup = array(
      'kupec' => $jmeno,
      'datum_nakupu' => date('Y-m-d H:i:s')
    );
    $nakup->update($dataNakup);

    $kupec = $this->kupec->get($jmeno);
    if($kupec) $kupec->update(array('dluh' => $kupec->dluh + $nakup->cena_prodej));
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
