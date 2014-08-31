<?php

namespace App\Model;

use Nette\Object,
	Nette\Database\Context as NDatabase;


/**
 * Abstraktní repozitář.
 */
abstract class Repository extends Object
{

	/** @var NDatabase */
	protected $database;
	
	/** @var string */
	protected $table;


	public function __construct(NDatabase $database)
	{
		$this->database = $database;
	}

	public function pok()
	{
		return $this->database->query(
      'SELECT nanuky.nazev, count(nanuky_id) AS pocet,
      (SELECT cena_prodej FROM sklad s2 WHERE s1.nanuky_id = s2.nanuky_id AND s2.kupci_id IS NULL AND s2.cena_prodej > 0 ORDER BY id LIMIT 1) AS cena
      FROM sklad s1, nanuky
      WHERE s1.nanuky_id = nanuky.id
      AND s1.kupci_id IS NULL
      AND s1.cena_prodej > 0
      GROUP BY nanuky_id;'
    );
	}
	
	/** 
	 * Vrátí všechny platné záznamy
	 * 
	 * @return \Nette\Database\Table\Selection
	 */
	public function findAll()
	{
		return $this->database->table($this->table);
	}
	
	
	/** 
	 * Vrátí kolekci záznamů podle podmínky
	 * 
	 * @param array
	 * @return \Nette\Database\Table\Selection
	 */
	public function findBy($where)
	{
		return $this->findAll()->where($where);
	}
	
	
	/** 
	 * Vrátí záznam podle primárního klíče
	 * 
	 * @param int
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function get($id)
	{
		return $this->findAll()->get($id);
	}
	
	
	/** 
	 * Vrátí jeden záznam podle podmínky
	 * 
	 * @param array
	 * @return \Nette\Database\Table\ActiveRow|FALSE
	 */
	public function getBy($where)
	{
		return $this->findAll()->where($where)->fetch();
	}
	
	
	
	/** 
	 * Vloží nový záznam do tabulky
	 * 
	 * @param array
	 * @return \Nette\Database\Table\IRow|int
	 */
	public function insert($data)
	{
		return $this->database->table($this->table)->insert($data);
	}

}
