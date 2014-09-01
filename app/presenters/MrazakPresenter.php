<?php

namespace App\Presenters;

use App\Model\NanukRepository,
    App\Model\SkladRepository,
    App\Model\KupecRepository,
    Nette\Application\UI\Form,
    Nextras\Forms\Rendering\Bs3FormRenderer;


/**
 * Mrazak presenter.
 */
final class MrazakPresenter extends BasePresenter
{
  
  /**
   * @var SkladRepository
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
  
  public function renderDefault()
  {
    $this->template->nanuky = $this->mrazak->inventura();
    $this->template->ceny = $this->mrazak->cenik()->fetchPairs('nanuky_id', 'cena');;
  }

  public function renderKoupit($nanuk, $kupec = null)
  {
    $mrazak = $this->mrazak->volnyNanuk($nanuk);
    $this['nakupForm']->setDefaults(array(
      "kupci_id" => $kupec,
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
  public function handleDelete($id)
  {
    $this->mrazak->get($id)->delete();
    $this->redirect('this');
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
   * Formulář pro nákup nanuku
   * @return Form
   */
  protected function createComponentNakupForm()
  {
    $form = new Form;

    $form->addSelect('kupci_id', 'Kupec', $this->kupec->seznamKupcu())
      ->setRequired('Řekni, kdo jsi.')
      ->setPrompt('Vyber, kdo jsi');
    $form->addText('nazev', 'Nanuk');
    $form->addText('cena_prodej', 'Cena');
    $form->addHidden('id');

    $form->addSubmit('ok', 'Koupit');

    $form->onSuccess[] = $this->nakupFormSuccess;

    $form->setRenderer(new Bs3FormRenderer);

    return $form;
  }


  /**
   * Zpracování formuláře pro zakoupeni nanuku
   * @param Form $form
   */
  public function nakupFormSuccess($form)
  {
    $values = $form->getValues();
    $this->koupit($values->kupci_id, $values->id);

    $this->flashMessage('Zakoupeno', 'success');
    $this->redirect('default');
  }

  /**
   * Fasáda pro zakoupení nanuku
   * @param $values[]
   */
  private function koupit($kupecId, $mrazakId)
  {
    $nanuk = $this->mrazak->get($mrazakId);
    $kupec = $this->kupec->get($kupecId);
    $nanuk->update(array('kupci_id' => $kupecId));
    $kupec->update(array('dluh' => $kupec->dluh + $nanuk->cena_prodej));
  }
}
