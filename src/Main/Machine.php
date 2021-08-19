<?php

namespace CI4\FrontEnd\Main;

use Config\Services;

class Machine
{
	// Get BladeOne object
	//
	// @var string $path
	protected function bladeone(string $path)
	{
		// return the object
		return new BladeOne($path, WRITEPATH . 'cache/');
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

		// return
		return $this->bladeone($path)->run($name, $data);
	}
}