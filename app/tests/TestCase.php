<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

    
    public function setUp(){
        parent::setUp();
    }
	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	
	
	public function console($msg){
// 	    echo "__" . get_class($this) . "." . $msg . "\n";
	    echo " * " . $msg . "\n";
	}
}
