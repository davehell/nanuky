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
    $this->zakaznik = strtoupper($this->zakaznik);
    $this->template->kupci = $this->kupec->seznamKupcu();
    $kupec = $this->kupec->get($this->zakaznik);
    $this->template->kupec = $kupec;
  }
}
