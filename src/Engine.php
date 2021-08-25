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

use CI4\FrontEnd\EngineWorkshop;

/**
 * Engine Class
 * 
 * This class prototype is
 * 	- Engine::start($view, [$data])->run($mode, $pipe);
 * 
 * $mode = 'auto'|'slow'|'fast'|'debug' (default 'auto')
 * $pipe = true|false (default false)
 * 
 * Actually, the engine got trouble. So we need
 * to fix in the workshop first, extend it.
 * 
 * The default views folder is in App/Views/
 * but you can use namespace too or even a string!!
 */

class Engine extends EngineWorkshop
{
	/**
	 * Code Version
	 * 
	 * @param const VERSION
	 */
	const VERSION = '1.0';

	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param array  $data
	 */
	protected function __construct(protected string $name, protected array $data = [], protected $meta = null) { }

	/**
	 * >> Start the healthy check!!!
	 * 
	 * @param string $name
	 * @param array  $data
	 */
	public static function start(string $name, array $data = [])
	{
		return new self($name, $data);
	}

	/**
	 * == Meta generator
	 * 
	 * Add your own meta tag by using this
	 * method.
	 * 
	 * Usage : start()->meta($meta)->run();
	 * 
	 * @param $set_meta_data
	 */
	public function meta($set_meta_data)
	{
		return new self($this->name, $this->data, $set_meta_data);
	}

	/**
	 * << Not runing as well :/
	 * 
	 * @param  string $mode
	 * @param  bool   $pipe
	 * @return view
	 */
	public function run(string $mode = 'auto', bool $pipe = false)
	{
		return $this->trouble($this->name, $this->data, $mode, $pipe) // we've found the trouble
					->fix($this->meta);                               // add an extra chips to fix it.
	}
}