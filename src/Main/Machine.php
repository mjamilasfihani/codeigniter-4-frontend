<?php

namespace CI4\FrontEnd\Main;

use Config\Services;

class Machine
{
	// Display object
	protected $display;

	// Constructor
	protected function __construct($display = null)
	{
		$this->display = $display;
	}

	// Get BladeOne object
	//
	// @var string $path
	protected function bladeone(string $path)
	{
		// return the object
		return new BladeOne($path, WRITEPATH . 'cache/');
	}

	// Tatter\Themes
	protected function tatterassets(string $bundle)
	{
		return $bundle;
	}

	// Begin the journey
	//
	// @var string $name
	// @var array  $data
	protected function journey(string $name, array $data = [])
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
		$bladeone = $this->bladeone($path);

		// return
		return new self($bladeone->run($name, $data));
	}

	// Set the destiny
	//
	protected function destiny(string $bundle)
	{
		return $this->tatterassets($this->display);
	}
}