<?php 

namespace CI4\FrontEnd\Library;

/**
 * MIT License
 *
 * Copyright (c) 2021 Mohammad Jamil Asfihani
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

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
	 * @param mix    $returnType null|bool|string
	 */
	public static function try(string $value, $returnType = null)
	{
		return self::default($value) ?? self::namespace($value) ?? $returnType;
	}
}