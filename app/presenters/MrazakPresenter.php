<?php

namespace App\Presenters;

use App\Model\NanukRepository,
    App\Model\SkladRepository,
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
  
  public function renderDefault()
  {
    $this->template->nanukyNaMrazaku = $this->mrazak->pok();
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
    
    $form->addSelect('nanuky_id', 'Nanuk', $this->nanuk->findAll()->fetchPairs('id', 'nazev'))
      ->setRequired('Vyber druh nanuku.')
      ->setPrompt('Vyber nanuk');
    $form->addText('cena', 'Nákupní cena [balení]')
      ->setRequired('Zadej nákupní cenu celého balení.');
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
    $values = $form->getValues();
    $pocet = $values['pocet'];
    unset($values['pocet']);
    unset($values['cena']);
    
    for($i=0; $i<$pocet; $i++) {
      $this->mrazak->insert($values);
    }

    $this->flashMessage('Přidáno', 'success');
    $this->redirect('pridat');
  }


}
