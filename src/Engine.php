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
 * 	- Engine::initialize($view, [$data])->run($pipe, $mode);
 * 
 * $pipe = true|false (default false)
 * $mode = 'auto'|'slow'|'fast'|'debug' (default 'auto')
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
	 * Object Initialize
	 * 
	 * @param string $name
	 * @param array  $data
	 * @param string $meta
	 */
	protected $name = null;
	protected $data = [];
	protected $meta = null;

	/**
	 * Constructor
	 * 
	 * @param string $name
	 * @param array  $data
	 * @param string $meta
	 */
	protected function __construct(string $name = null, array $data = [], $meta = null)
	{
		$this->name = $name ?? $this->name;
		$this->data = $data ?? $this->data;
		$this->meta = $meta ?? $this->meta;
	}

	/**
	 * >> Start the healthy check!!!
	 * 
	 * @param string $name
	 * @param array  $data
	 */
	public static function initialize(string $name, array $data = [])
	{
		return new self($name, $data);
	}

	/**
	 * == Meta generator
	 * 
	 * Add your own meta tag by using this
	 * method.
	 * 
	 * Usage : initialize()->meta($meta)->run();
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
	 * @param  bool   $pipe
	 * @param  string $mode
	 * @return view
	 */
	public function run(bool $pipe = false, string $mode = 'auto')
	{
		return $this->trouble($this->name, $this->data, $pipe, $mode) // we've found the trouble
					->fix($this->meta);                               // add an extra chips to fix it.
	}
}