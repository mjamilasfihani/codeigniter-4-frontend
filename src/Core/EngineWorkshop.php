<?php

namespace CI4\FrontEnd\Core;

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

use CI4\FrontEnd\Libraries\BladeOne;
use CI4\FrontEnd\Libraries\FindPath;
use BladeOneDirectiveRT;

class EngineWorkshop
{
	/**
	 * Object Initialize
	 * 
	 * @param object $bladeone
	 * @param array  $value
	 */
	protected $bladeone = null;
	protected $value    = [];

	/**
	 * Constructor
	 * 
	 * @param object $bladeone
	 * @param array  $value
	 */
	protected function __construct($bladeone = null, array $value = [])
	{
		$this->bladeone = $bladeone ?? $this->bladeone;
		$this->value    = $value    ?? $this->value;
	}

	/**
	 * Core
	 * 
	 * @param string $path
	 * @param bool   $pipe
	 * @param string $mode
	 */
	protected function core(string $path, bool $pipe = false, string $mode = 'auto')
	{
		// initialize BladeOne
		$bladeone = new BladeOne($path, WRITEPATH . 'cache/');

		// initialize directiveRT()
		$bladeone = BladeOneDirectiveRT::getTag($bladeone);

		// bladeone mode
		switch ($mode)
		{
			case 'auto':
				$bladeone->setMode($bladeone::MODE_AUTO);
				break;
			case 'slow':
				$bladeone->setMode($bladeone::MODE_SLOW);
				break;
			case 'fast':
				$bladeone->setMode($bladeone::MODE_FAST);
				break;
			case 'debug':
				$bladeone->setMode($bladeone::MODE_DEBUG);
				break;
			default:
				log_message('error', 'CI4\FrontEnd - mode:\'{0}\' is invalid value.', [0 => $mode]);
				break;
		};

		// check the pipe (filter)
		$bladeone->pipeEnable = $pipe;

		// set the bladeone base url
		$bladeone->setBaseUrl(base_url());

		// return the bladeone object
		return $bladeone;
	}

	/**
	 * Here is the trouble begin :)
	 * 
	 * @param string $name
	 * @param array  $data
	 * @param bool   $pipe
	 * @param string $mode
	 */
	protected function trouble(string $name, array $data = [], bool $pipe = false, string $mode = 'auto')
	{
		// if FindPath::try(string) return '', than user try to use
		// string not the view file right?
		return new self($this->core(FindPath::try($name, ''), $pipe, $mode), [
			'name' => $name,
			'data' => $data,
		]);
	}

	/**
	 * Yey, it fixed now :)
	 * 
	 * @param $get_meta_data
	 */
	protected function fix($get_meta_data)
	{
		// set the data
		$name = $this->value['name'];
		$data = $this->value['data'];

		// decide the render type
		if (FindPath::try($name) == null)
		{
			$bladeone = $this->bladeone->runString($name, $data);
		}
		else
		{
			$bladeone = $this->bladeone->run(class_basename($name), $data);
		}

		// decide the render file
		// create your own layout based on the origin.
		if (is_file(APPPATH . 'Views/layout/render.php'))
		{
			$layout = 'layout/render';
		}
		else
		{
			$layout = '\CI4\FrontEnd\Views\layout\render';
		}

		// render to view
		return view($layout, ['render' => $bladeone, 'meta' => $get_meta_data]);
	}
}