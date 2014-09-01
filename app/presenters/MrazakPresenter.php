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

  /** @var string */
  private $dlouzek;
  
  public function renderDefault($zakaznik = null)
  {
    $this->template->nanuky = $this->mrazak->inventura();
    $this->template->ceny = $this->mrazak->cenik()->fetchPairs('nanuky_id', 'cena');
    $kupec = $this->kupec->get($zakaznik);
    $this->template->kupec = $kupec;

    if($this->dlouzek === NULL) {
      if($kupec) $this->dlouzek = $kupec->dluh;
    }
    $this->template->dlouzek = $this->dlouzek;
  }

  public function renderKoupit($nanuk, $zakaznik = null)
  {
    $mrazak = $this->mrazak->volnyNanuk($nanuk);
    $this['nakupForm']->setDefaults(array(
      "kupec" => $zakaznik,
      "id" => $mrazak->id,
      "nazev" => $mrazak->nazev,
      "cena_prodej" => $mrazak->cena
    ));
  }

  public function renderPridat()
  {
    $this->template->velikostBaleni = $this->nanuk->findAll()->fetchPairs('id', 'baleni');
  }


  /**
   * @param int
   */
  public function handleKoupit($nanuk, $zakaznik)
  {
    $mrazak = $this->mrazak->volnyNanuk($nanuk);
    $this->koupitNanuk($zakaznik, $mrazak->id);

    $kupec = $this->kupec->get($zakaznik);
    $this->dlouzek = $kupec->dluh;
    $this->flashMessage('Zakoupen nanuk ' . $mrazak->nazev . ' za ' . $mrazak->cena . ' Kč', 'success');
    if ($this->isAjax()) {
      $this->invalidateControl('stranka');
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
   * @param $values[]
   */
  private function koupitNanuk($jmeno, $mrazakId)
  {
    $nanuk = $this->mrazak->get($mrazakId);
    $kupec = $this->kupec->get($jmeno);

    $nanuk->update(array('kupec' => $jmeno));
    $kupec->update(array('dluh' => $kupec->dluh + $nanuk->cena_prodej));
  }
}
