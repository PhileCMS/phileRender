<?php

/**
 * Render a markdown file inline
 * Usage: {{ render('page_url') }}
 */

class PhileRender extends \Phile\Plugin\AbstractPlugin implements \Phile\EventObserverInterface {
	public function __construct() {
		\Phile\Event::registerEvent('template_engine_registered', $this);
	}

	/**
	 * find a path by the path
	 * @param  string $pagepath the page you are looking for
	 * @return page           the found page
	 */
	private function find_page($pagepath) {
		$pageRespository = new \Phile\Repository\Page();
		$page = $pageRespository->findByPath($pagepath);
		if (is_null($page)) {
			return false;
		}
		if (isset($this->settings['conditional_checks']) && is_array($this->settings['conditional_checks'])) {
			// get all the meta for the found page
			$metaModel = $page->getMeta()->getAll();
			// we could be checking multiple pages, so lets just assume this page doesn't meet the criteria
			$render = false;
			// the key to look for matches the value
			foreach ($this->settings['conditional_checks'] as $key => $value) {
				$render = ($metaModel[$key] == $value);
			}
			// all of the tests passed
			if ($render) {
				return $page;
			} else {
				// false will fail silently
				return false;
			}
		} else {
			return $page;
		}
	}

	public function on($eventKey, $data = null) {
		if ($eventKey == 'template_engine_registered') {
			$render = new Twig_SimpleFunction('render', function ($path) {
				$page = $this->find_page($path);
				if ($page !== false) {
					// render the content for this page
					return $page->getContent();
				} else {
					// if there is no page, returning null will fail silently
					return null;
				}
			});
			$data['engine']->addFunction($render);
		}
	}
}
