<?php

class Paginator {

	private $_total;
	private $_page;
	private $_limit;

	public function  __construct($total, $page, $limit)
	{
		$this->_total = $total;
		$this->_page = $page;
		$this->_limit = $limit;
	}

	public function hasPreviousPage()
	{
		return ($this->_page>1)?true:false;
	}

	public function getPreviousPage()
	{
		return $this->_page - 1;
	}

	public function hasNextPage()
	{

		return (($this->_page * $this->_limit) < $this->_total)?true:false;
	}

	public function getNextPage()
	{
		return $this->_page + 1;
	}

	public function getTotal()
	{
		return $this->_total;
	}

}
?>	
