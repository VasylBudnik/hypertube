<?php

namespace App\Core;

class Pagination
{
	private $max = 3;
	private $route;
	private $index = '';
	private $current_page;
	private $total;
	private $limit;

	public function __construct($route, $total, $limit = 18) {
		$this->route = $route;
		$this->total = $total;
		$this->limit = $limit;
		$this->amount = $this->amount();
		$this->setCurrentPage();
	}

	public function get()
    {
		$links = null;
		$limits = $this->limits();
		$html = '<ul class="pagination">';
		for ($page = $limits[0]; $page <= $limits[1]; $page++) {
			if ($page == $this->current_page) {
				$links .= '<li class="pg-active"><a>'.$page.'</a></li>';
			} else {
				$links .= $this->generateHtml($page);
			}
		}
		if (!is_null($links)) {
			if ($this->current_page > 1) {
				$links = $this->generateHtml(1, 'В начало').$links;
			}
			if ($this->current_page < $this->amount) {
				$links .= $this->generateHtml($this->amount, 'В конец');
			}
		}
		$html .= $links.' </ul>';
		return $html;
	}

	private function generateHtml($page, $text = null)
    {
		if (!$text) {
			$text = $page;
		}
		return '<li><a class="page-link" href="/'.$this->route.'?page='.$page.'">'.$text.'</a></li>';
	}

	private function limits()
    {
		$left = $this->current_page - round($this->max / 2);
		$start = $left > 0 ? $left : 1;
		if ($this->current_page >= 3) {
            $start = $this->current_page - 1;
        }
		if ($start + $this->max <= $this->amount) {
			$end = $start > 1 ? $start + $this->max : $this->max;
		} else {
			$end = $this->amount;
			$start = $this->amount - $this->max > 0 ? $this->amount - $this->max : 1;
		}
		return array($start, $end);
	}

	private function setCurrentPage()
    {
		if (isset($_GET['page'])) {
			$currentPage = $_GET['page'];
		} else {
			$currentPage = 1;
		}
		$this->current_page = $currentPage;
		if ($this->current_page > 0) {
			if ($this->current_page > $this->amount) {
				$this->current_page = $this->amount;
			}
		} else {
			$this->current_page = 1;
		}
	}

	private function amount()
    {
		return ceil($this->total / $this->limit);
	}
}
