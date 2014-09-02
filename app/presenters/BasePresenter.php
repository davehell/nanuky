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


  public function beforeRender()
  {
    $this->template->uziv = null;
    $this->template->seznamKupcu = $this->kupec->seznamKupcu();
  }
}
