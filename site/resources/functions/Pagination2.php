<?php

class Pagination {
    public $perPage = 15;

    private $_url = '';
    private $_total = null;
    private $_pageCount = 0;

    public function  __construct($url = '', $total = null)
    {
        $this->_url = $url;
        $this->_total = $total;
    }
	
    function getPages($currentPage = null) {

        if ($this->_total > 0) {
			$this->_pageCount = ceil($this->_total / $this->perPage);
			$pageCount = $this->_pageCount;
			
			$pages ='<div class="margin-top-20"><ul class="pagination">';
			
             if ($currentPage > 1) {
				$pages .= '<li><a class="paging" data-page="'.($currentPage-1).'" href="#"> Prev </a></li>';
			 }
			 
			if($this->_pageCount > 1)
			{
				for ($i = 1; $i <= $pageCount; $i++)
				{
					$currentPage==$i ? $class=' class="active"' : $class='';
					$pages .= '<li'.$class.'><a class="paging" data-page="'.$i.'" href="#">'.$i.'</a></li>';
				}
			}
			 
			 if ($currentPage < $this->_pageCount) {
				$pages .= '<li><a class="paging" data-page="'.($currentPage+1).'" href="#">	Next </a></li>';
			 }
        }

        return $pages;
    }
}
?>	