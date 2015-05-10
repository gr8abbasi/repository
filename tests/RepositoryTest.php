<?php namespace Gr8abbasi\Repository\tests;

use BGr8abbasi\Repository\Contracts\CriteriaInterface as Criteria;
use Gr8abbasi\Repository\Contracts\RepositoryInterface as Repository;
use Gr8abbasi\Repository\Eloquent\EloquentRepository;
use Illuminate\Database\Eloquent\Model;
use \Mockery as m;
use \PHPUnit_Framework_TestCase as TestCase;

class RepositoryTest extends TestCase {
	
	protected $mock;

	protected $repository;
	
	public function setUp() {
		//$this->mock = m::mock('Illuminate\Database\Eloquent\Model');
	}

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$response = $this->call('GET', '/auth');
		$this->assertEquals(200, $response->getStatusCode());
	}
}

?>