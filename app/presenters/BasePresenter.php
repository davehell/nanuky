<?php

namespace App\Presenters;

use Nette,
    App\Model,
    App\Model\KupecRepository;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
  /**
   * @var KupecRepository
   * @inject
   */
  public $kupec;

  /** @persistent */
  public $zakaznik;

  public function beforeRender()
  {
    $this->template->kupci = $this->kupec->seznamKupcu();
    $this->template->zakaznik = $this->zakaznik;
    $kupec = $this->kupec->get($this->zakaznik);
    $this->template->dlouzek = $kupec ? $kupec->dluh : null;
  }
}
