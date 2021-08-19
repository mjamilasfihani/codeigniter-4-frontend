<?php

namespace CI4\FrontEnd;

use CI4\FrontEnd\Main\Machine;

class Engine extends Machine
{
	/**
	 * Define the view filename
	 * 
	 * @var string $name
	 */
	protected $name;
	
	/**
	 * Define the view data
	 * 
	 * @var array $data
	 */
	protected $data = [];

	/**
	 * Constructor
	 * 
	 * @var string $name
	 * @var array  $data
	 */
	protected function __construct(string $name, array $data = [])
	{
		$this->name = $name;
		$this->data = $data;
	}

	//--------------------------------------------------------------------

	/**
	 * >> Start the Engine!!!
	 * 
	 * @var string $name
	 * @var array  $data
	 */
	public static function start(string $name, array $data = [])
	{
		return new self($name, $data);
	}

	/**
	 * << Begin the Journey
	 * 
	 * The prototype will be :
	 *
	 * 		Engine::start($view, [$data])->run();
	 * 
	 * @return view
	 */
	public function run()
	{
		return $this->journey($this->name, $this->data);
	}
}