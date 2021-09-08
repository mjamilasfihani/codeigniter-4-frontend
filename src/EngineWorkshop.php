<?php

namespace CI4\FrontEnd;

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

use CI4\FrontEnd\BladeOne\BladeOne;
use CI4\FrontEnd\BladeOne\BladeOneDirectiveRT;
use CI4\FrontEnd\Libraries\ViewLocator;

class EngineWorkshop
{
	/**
	 * Object Initialize
	 * 
	 * @param object $engine
	 * @param array  $value
	 */
	protected $engine = null;
	protected $value  = [];

	/**
	 * Constructor
	 * 
	 * @param object $engine
	 * @param array  $value
	 */
	protected function __construct($engine = null, array $value = [])
	{
		$this->engine = $engine ?? $this->engine;
		$this->value  = $value  ?? $this->value;
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
		$engine = new BladeOne($path, WRITEPATH . 'cache/');

		// initialize BladeOne directiveRT()
		$engine = BladeOneDirectiveRT::getTag($engine);

		// BladeOne mode
		switch ($mode)
		{
			case 'auto':
				$engine->setMode($engine::MODE_AUTO);
				break;
			case 'slow':
				$engine->setMode($engine::MODE_SLOW);
				break;
			case 'fast':
				$engine->setMode($engine::MODE_FAST);
				break;
			case 'debug':
				$engine->setMode($engine::MODE_DEBUG);
				break;
			default:
				log_message('error', 'CI4\FrontEnd - mode:\'{0}\' is invalid value.', [0 => $mode]);
				break;
		};

		// check the BladeOne pipe (filter)
		$engine->pipeEnable = $pipe;

		// set the BladeOne base url
		$engine->setBaseUrl(base_url());

		// return the BladeOne object
		return $engine;
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
		// if ViewLocator::try(string) return '', than user try to use
		// string not the view file right?
		return new self($this->core(ViewLocator::try($name, '', '.blade.php'), $pipe, $mode), [
			'name' => $name,
			'data' => $data,
		]);
	}

	/**
	 * Yeay, it fixed now :)
	 * 
	 * @param $get_meta_data
	 */
	protected function fix($get_meta_data)
	{
		// set the data
		$name = $this->value['name'];
		$data = $this->value['data'];

		// decide the render type
		if (ViewLocator::try($name, null, '.blade.php') == null)
		{
			$engine = $this->engine->runString($name, $data);
		}
		else
		{
			$engine = $this->engine->run(class_basename($name), $data);
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
		return view($layout, ['render' => $engine, 'meta' => $get_meta_data]);
	}
}