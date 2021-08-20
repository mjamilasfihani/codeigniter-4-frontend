<?php 

namespace CI4\FrontEnd\Library;

use Config\Services;

class FindPath
{
	/**
	 * Check if it's a file, and return the
	 * folder name
	 * 
	 * @param  string $source
	 * @return string|null
	 */
	protected static function getRealPath(string $source)
	{
		$realfile = realpath($source);

		if (is_file($realfile))
		{
			return dirname($realfile) . DIRECTORY_SEPARATOR;
		}
		else
		{
			return null;
		}
	}

	/**
	 * Default Path
	 * 
	 * @param string $filename
	 */
	protected static function default(string $filename)
	{
		return self::getRealPath(APPPATH . 'Views/' . $filename . '.blade.php');
	}

	/**
	 * Namespace
	 * 
	 * @param string namespace
	 */
	protected static function namespace(string $namespace)
	{
		return self::getRealPath(Services::locator()->locateFile($namespace, 'Views', 'blade.php'));
	}

	/**
	 * try
	 * 
	 * @param string $value
	 */
	public static function try(string $value)
	{
		return self::default($value) ?? self::namespace($value) ?? null;
	}
}