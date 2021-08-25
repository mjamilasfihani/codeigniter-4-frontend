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

use CI4\FrontEnd\Library\BladeOne;
use CI4\FrontEnd\Library\FindPath;
use CI4\FrontEnd\Trait\BladeOneDirectiveRT;

class EngineWorkshop
{
	/**
	 * Constructor
	 * 
	 * @param string $bladeone
	 * @param array  $value
	 */
	protected function __construct(protected $bladeone = null, protected array $value = []) { }

	/**
	 * Initialize
	 * 
	 * @param string $path
	 * @param string $mode
	 * @param bool   $pipe
	 */
	protected function initialize(string $path, string $mode = 'auto', bool $pipe = false)
	{
		// initialize BladeOne
		$bladeone = new BladeOne($path, WRITEPATH . 'cache/');

		// initialize directiveRT()
		$bladeone = BladeOneDirectiveRT::getTag($bladeone);

		// bladeone mode
		$bladeone->setMode(match ($mode)
		{
			'auto'  => $bladeone::MODE_AUTO,
			'slow'  => $bladeone::MODE_SLOW,
			'fast'  => $bladeone::MODE_FAST,
			'debug' => $bladeone::MODE_DEBUG,
		});

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
	 * @param string $mode
	 * @param bool   $pipe
	 */
	protected function trouble(string $name, array $data = [], string $mode = 'auto', bool $pipe = false)
	{
		// if FindPath::try(string) return '', than user try to use
		// string not the view file right?
		return new self($this->initialize(FindPath::try($name, ''), $mode, $pipe), [
			'name' => $name,
			'data' => $data,
		]);
	}

	/**
	 * Yey, it fixed now :)
	 * 
	 * @param string $get_meta_data
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
			$bladeone = $this->bladeone->run($name, $data);
		}

		// render to view
		return view('\CI4\FrontEnd\Views\render', ['render' => $bladeone, 'meta' => $get_meta_data]);
	}
}