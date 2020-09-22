<?php namespace thiagoalessio\TesseractOCR\Tests\Unit;

use thiagoalessio\TesseractOCR\Command;

class TestableCommand extends Command
{
	public function __construct($image=null, $version='3.05')
	{
		parent::__construct($image);
		$this->version = $version;
	}

	public function getTesseractVersion() { return $this->version; }

	public function getOutputFile() { return 'tmpfile'; }
}
