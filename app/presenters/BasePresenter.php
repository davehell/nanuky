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
  public $uziv = '';

  public function beforeRender()
  {
    $this->template->uziv = '';
    $this->template->dluh = 0;
    if($this->uziv) {
      $kupec = $this->kupec->get(strtoupper($this->uziv));
      if(!$kupec) throw new \Nette\Application\BadRequestException("Neexistující kupec.");
      $this->template->uziv = $kupec;
      $this->template->dluh = $this->kupec->zaokrouhliDluh($kupec->dluh);
    }
  }
}
