<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/* phpFlickr Class 3.1
 * Written by Dan Coulter (dan@dancoulter.com)
 * Project Home Page: http://phpflickr.com/
 * Released under GNU Lesser General Public License (http://www.gnu.org/copyleft/lgpl.html)
 * For more information about the class and upcoming tools and toys using it,
 * visit http://www.phpflickr.com/
 *
 *	 For installation instructions, open the README.txt file packaged with this
 *	 class. If you don't have a copy, you can see it at:
 *	 http://www.phpflickr.com/README.txt
 *
 *	 Please submit all problems or questions to the Help Forum on my Google Code project page:
 *		 http://code.google.com/p/phpflickr/issues/list
 *
 */ 

	class Phpflickr_pager {
		var $phpFlickr, $per_page, $method, $args, $results, $global_phpFlickr;
		var $total = null, $page = 0, $pages = null, $photos, $_extra = null;
		
		
		public function phpFlickr_pager($phpFlickr, $method = null, $args = null, $per_page = 30) {
			$this->per_page = $per_page;
			$this->method = $method;
			$this->args = $args;
			$this->set_phpFlickr($phpFlickr);
		}
		
		public function set_phpFlickr($phpFlickr) {
			if ( is_a($phpFlickr, 'phpFlickr') ) {
				$this->phpFlickr = $phpFlickr;
				if ( $this->phpFlickr->cache ) {
					$this->args['per_page'] = 500;
				} else {
					$this->args['per_page'] = (int) $this->per_page;
				}
			}
		}
		
		public function __sleep() {
			return array(
				'method',
				'args',
				'per_page',
				'page',
				'_extra',
			);
		}
		
		public function load($page) {
			$allowed_methods = array(
				'flickr.photos.search' => 'photos',
				'flickr.photosets.getPhotos' => 'photoset',
			);
			if ( !in_array($this->method, array_keys($allowed_methods)) ) return false;
			
			if ( $this->phpFlickr->cache ) {
				$min = ($page - 1) * $this->per_page;
				$max = $page * $this->per_page - 1;
				if ( floor($min/500) == floor($max/500) ) {
					$this->args['page'] = floor($min/500) + 1;
					$this->results = $this->phpFlickr->call($this->method, $this->args);
					if ( $this->results ) {
						$this->results = $this->results[$allowed_methods[$this->method]];
						$this->photos = array_slice($this->results['photo'], $min % 500, $this->per_page);
						$this->total = $this->results['total'];
						$this->pages = ceil($this->results['total'] / $this->per_page);
						return true;
					} else {
						return false;
					}
				} else {
					$this->args['page'] = floor($min/500) + 1;
					$this->results = $this->phpFlickr->call($this->method, $this->args);
					if ( $this->results ) {
						$this->results = $this->results[$allowed_methods[$this->method]];

						$this->photos = array_slice($this->results['photo'], $min % 500);
						$this->total = $this->results['total'];
						$this->pages = ceil($this->results['total'] / $this->per_page);
						
						$this->args['page'] = floor($min/500) + 2;
						$this->results = $this->phpFlickr->call($this->method, $this->args);
						if ( $this->results ) {
							$this->results = $this->results[$allowed_methods[$this->method]];
							$this->photos = array_merge($this->photos, array_slice($this->results['photo'], 0, $max % 500 + 1));
						}
						return true;
					} else {
						return false;
					}

				}
			} else {
				$this->args['page'] = $page;
				$this->results = $this->phpFlickr->call($this->method, $this->args);
				if ( $this->results ) {
					$this->results = $this->results[$allowed_methods[$this->method]];
					
					$this->photos = $this->results['photo'];
					$this->total = $this->results['total'];
					$this->pages = $this->results['pages'];
					return true;
				} else {
					return false;
				}
			}
		}
		
		public function get($page = null) {
			if ( is_null($page) ) {
				$page = $this->page;
			} else {
				$this->page = $page;
			}
			if ( $this->load($page) ) {
				return $this->photos;
			}
			$this->total = 0;
			$this->pages = 0;
			return array();
		}
		
		public function next() {
			$this->page++;
			if ( $this->load($this->page) ) {
				return $this->photos;
			}
			$this->total = 0;
			$this->pages = 0;
			return array();
		}
		
	}

