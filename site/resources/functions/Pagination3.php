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
			
            $pages ='<div>';
            $pages .= '<div style="float:left;">'.$currentPage.' of ' .$this->_pageCount . ' Pages. Total '.$this->_total.' Items.</div>';
            $pages .='<ul class="pagination" style="float:right;">';
			
             if ($currentPage > 1) {
				$pages .= '<li><a class="paging" data-page="'.($currentPage-1).'" href="#"> Prev </a></li>';
			 }
			 
			if($this->_pageCount > 1)
			{
                $c = 0;
				for ($i = ($currentPage - 2); $i <= $currentPage + 2; $i++)
				{
                    if ($i <= 0 ) continue;
                    if ($i > $this->_pageCount ) continue;
					$currentPage==$i ? $class=' class="active"' : $class='';
					$pages .= '<li'.$class.'><a class="paging" data-page="'.$i.'" href="#">'.$i.'</a></li>';
                    if ($c >= 5) {
                        break;
                    }
                    $c = $c + 1;
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
