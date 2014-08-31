<?php

namespace App\Presenters;

use App\Model\BookRepository,
	App\Model\AuthorRepository,
    Nette\Application\UI\Form,
	Nextras\Forms\Rendering\Bs3FormRenderer;


/**
 * Bookcase presenter.
 */
final class BookcasePresenter extends BasePresenter
{
	
	/**
	 * @var BookRepository
	 * @inject
	 */
	public $books;
	
	/**
	 * @var AuthorRepository
	 * @inject
	 */
	public $authors;
	
	
	
	public function renderList()
	{
		$this->template->books = $this->books->findAll();
	}
	
	
	/**
	 * @param int
	 */
	public function actionEdit($id)
	{
		$book = $this->books->get($id);
		$this['bookForm']->setDefaults($book);
	}

	
	/**
	 * @param int
	 */
	public function handleDelete($id)
	{
		$this->books->get($id)->delete();
		$this->redirect('this');
	}
	
	
	/**
	 * Formulář pro vytvoření, nebo editaci knihy.
	 * @return Form
	 */
	protected function createComponentBookForm()
	{
		$form = new Form;
		
		$form->addHidden('id');
		$form->addText('title', 'Název knihy')
			->setRequired('Vyplňte název knihy.');
		$form->addSelect('id_author', 'Autor', $this->authors->findAll()->fetchPairs('id', 'name'))
			->setRequired('Vyberte autora knihy.');
		$form->addSubmit('ok', 'Odeslat');
		
		$form->onSuccess[] = $this->bookFormSuccess;
		
		$form->setRenderer(new Bs3FormRenderer);

		return $form;
	}


	/**
	 * Zpracování formuláře pro vytvoření, nebo editaci knihy.
	 * @param Form $form
	 */
	public function bookFormSuccess($form)
	{
		$values = $form->getValues();
		
		if(empty($values->id)) {
			$this->books->insert($values);
		}
		else {
			$book = $this->books->get($values->id);
			$book->update($values);
		}
		
		$this->redirect('list');
	}


}
