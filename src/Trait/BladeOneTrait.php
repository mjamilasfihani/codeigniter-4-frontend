<?php

namespace CI4\FrontEnd\Trait;

trait BladeOneTrait
{
	// @csrf_token()
	protected function compileCsrf_token()
	{
		return "<?php echo csrf_token() ?>";
	}

	// @csrf_header()
	protected function compileCsrf_header()
	{
		return "<?php echo csrf_header() ?>";
	}

	// @csrf_field()
	protected function compileCsrf_field()
	{
		return "<?php echo csrf_field() ?>";
	}

	// @csrf_meta()
	protected function compileCsrf_meta()
	{
		return "<?php echo csrf_meta() ?>";
	}
}