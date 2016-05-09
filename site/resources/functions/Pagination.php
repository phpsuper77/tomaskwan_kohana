<?php

class Pagination {
    public $perPage = 4;

    private $_url = '';
    private $_total = null;
    private $_pageCount = 0;
	private $_count = 0;

    public function  __construct($url = '', $total = null, $count = 0)
    {
        $this->_url = $url;
        $this->_total = $total;
		$this->_count = $count;
    }
	
    function getPages($currentPage = null) {

        if ($this->_total > 0) {
			$this->_pageCount = ceil($this->_total / $this->perPage);
			$pageCount = $this->_pageCount;
			
			if($currentPage == 1)
				$from = 1;
			else
				$from = $currentPage*$this->perPage+1;
			
			//$pages = '<span class="pagination-info">'.$from.'-'.$this->_count.' of '.$this->_total.'</span>';
			$pages = '<span class="pagination-info">'.$currentPage.' of '.$this->_pageCount.' Pages</span>';
			
             if ($currentPage > 1) {
				$pages .= '&nbsp;<a style="float:right;" class="btn btn-sm blue" href="'.URL::base(true).$this->_url.'/'.($currentPage-1).'"><i class="fa fa-angle-left"></i></a>';
			 }
			 if ($currentPage < $this->_pageCount) {
				$pages .= '&nbsp;<a style="float:right;" class="btn btn-sm blue" href="'.URL::base(true).$this->_url.'/'.($currentPage+1).'"><i class="fa fa-angle-right"></i></a>';
			 }
        }

        return $pages;
    }
}
?>	
