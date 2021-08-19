<?php

namespace CI4\FrontEnd\Main;

use eftec\bladeone\BladeOne as BladeOneCore;
use CI4\FrontEnd\Trait\BladeOneTrait;

class BladeOne extends BladeOneCore
{
	// use trait, keep the origin version
	use BladeOneTrait;
}