<?php

namespace CI4\FrontEnd\Main;

use Config\Services;

class Machine
{
	/**
	 * Display object
	 */
	protected $display;

	/**
	 * Constructor
	 * 
	 * @param string $display
	 */
	protected function __construct($display = null)
	{
		$this->display = $display;
	}

	/**
	 * Begin the journey :)
	 * 
	 * @var string $name
	 * @var array  $data
	 */
	protected function display(string $name, array $data = [])
	{
		// set the default one
		$view = APPPATH . 'Views/' . $name . '.blade.php';

		// if is not a file, it MUST BE namespace
		if (! is_file($view))
		{
			$view = Services::locator()->locateFile($name, 'Views', 'blade.php');
		}

		// re config for feeding the BladeOne
		$path = dirname(realpath($view)) . DIRECTORY_SEPARATOR;
		$name = basename($name);

		// get the BladeOne object
		$bladeone = new BladeOne($path, WRITEPATH . 'cache/');

		// return
		return new self($bladeone->run($name, $data));
	}

	/**
	 * Sadly, time to go home :(
	 */
	protected function now()
	{
		return view('\CI4\FrontEnd\Views\render', [
			'i' => $this->display,
			'c' => service('assets'),
		]);
	}
}