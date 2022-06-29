<?php

namespace Mjamilasfihani\CodeIgniter4FrontEnd;

use Jenssegers\Blade\Blade;

class Generate
{
	/**
	 * Blade
	 */
	protected $blade = null;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Blade Class
		$this->blade = new Blade();
	}

	/**
	 * Rendering
	 */
	public function render(string $view, array $data = [])
	{
		return $this->blade->make($view, $data)->render();
	}
}
