<?php

namespace App\Model;


/**
 * Repozitář pro práci s tabulkou 'book'.
 */
class BookRepository extends Repository
{

	protected $table = 'book';
	
	
	/** 
	 * @param string
	 * @return \Nette\Database\Table\Selection
	 */
	public function findByAuthor($name)
	{
		return $this->findBy();
	}


}
