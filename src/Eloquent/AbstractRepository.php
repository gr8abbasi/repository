<?php namespace Gr8abbasi\Repository\Eloquent;

use Gr8abbasi\Repository\Contracts\RepositoryInterface;
use Gr8abbasi\Repository\Exceptions\RepositoryException;
use Gr8abbasi\Repository\Contracts\CriteriaInterface;
use Gr8abbasi\Repository\Criteria\Criteria;

use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Model;

abstract class AbstractRepository implements RepositoryInterface, CriteriaInterface
{

	/*
	|--------------------------------------------------------------------------
	| AbstractRepository
	|--------------------------------------------------------------------------
	|
	| This repository perform all the database operations on a Table!
	|
	*/

	/**	
	* @var $app
	*/
	private $app;

	/**	
	* @var $model
	*/
	protected $model;

	/**	
	* @var Collection
	*/
	protected $criteria;

	/**	
	* @var bool
	*/
	protected $skipCriteria = false;

	/**
     * Constructor for AbstractRepository.
     *
     * @param App $app
     *
     */
	public function __construct(App $app, Collection $collection)
	{
		$this->app = $app;
		$this->criteria = $collection;
		$this->resetScope();
		$this->makeModel();
	}

	/**
     * Returns required Eloquent Model.
     *
     * @return mixed
     */
	public abstract function model();

	/**
     * Returns the array or mixed data from database.
     *
     * @param string|array $columns
     *
     * @return mixed
     */
	public function all($columns = array('*'))
	{
		$this->applyCriteria();
		return $this->model->get($columns);
	}
	
	/**
     * Returns the array of lists (key=>value pairs) data from database.
     *
     * @param string $value
     * @param string $key
     *
     * @return array
     */
     public function lists($value, $key = null)
     {
     	$this->applyCriteria();
     	return $this->model->lists($value, $key);
     }

     /**
     * Returns paginated requested mix or array data from database.
     *
     * @param string|int $perPage
     * @param string|array $columns
     *
     * @return mixed
     */
	public function paginate($perPage = 10, $columns = array('*'))
	{
		$this->applyCriteria();
		return $this->model->paginate($perPage, $columns);
	}

	/**
     * Creates a new record in database.
     *
     * @param array $data
     *
     * @return mixed
     */
	public function create(array $data)
	{
		return $this->model->create($data);
	}

	/**
     * Updates a particular record in database using its ID.
     *
     * @param array $data
     * @param int|string $id
     *
     * @return mixed
     */
	public function update(array $data, $id)
	{
		return $this->model->update($data, $id);
	}

	/**
     * Deletes a particular record in database using its ID.
     *
     * @param int|string $id
     *
     * @return mixed
     */
	public function delete($id)
	{
		return $this->model->destroy($id);
	}

	/**
     * Fetch specified columns for a particular record from database using its ID.
     *
     * @param int|string $id
     * @param array $columns
     *
     * @return mixed
     */
	public function find($id, $columns = array('*'))
	{
		$this->applyCriteria();
		return $this->model->find($id, $columns);
	}

	/**
     * Fetch specified columns for a particular record from database using its field's value.
     *
     * @param string $field
     * @param string $value
     * @param array $columns
     *
     * @return mixed
     */
	public function where($attribute, $value, $columns = array('*'))
	{
		$this->applyCriteria();
		return $this->model->where($attribute, '=', $value)->first($columns);
	}

	/**
	 * Create required Eloquent Model.
	 *
	 * @return object $model
	 */
	public function makeModel()
	{
		$model = $this->app->make($this->model());
		
		if(!$model instanceof Model)
			throw new RepositoryException("Class {$this->model} must be an instance of Jenssegers\Mongodb\Model");

		return $this->model = $model;
	}

	/**
     * To use eager loading provided by laravel we should have __call function to handle it
     * e.g. findByUsername. 
     *
     * @param string $method
     * @param mixed $args
     *
     * @return mixed
     */
	public function __call($method, $args)
    {
    	if(!method_exists($this,$method))
        	return call_user_func_array([$this->model, $method], $args);

        throw new RepositoryException("{$method} already exists!");
    }

    /**
	* @return $this
	*/
	public function resetScope()
	{
		$this->skipCriteria(false);
		return $this;
	}

	/**
	* @param bool $status
	* @return $this
	*/
	public function skipCriteria($status = true)
	{
		$this->skipCriteria = $status;
		return $this;
	}

	/**
	* @return mixed
	*/
	public function getCriteria()
	{
		return $this->criteria;
	}

	/**
	* @param Criteria $criteria
	* @return $this
	*/
	public function getByCriteria(Criteria $criteria)
	{
		$this->model = $criteria->apply($this->model, $this);
		return $this;
	}

	/**
	* @param Criteria $criteria
	* @return $this
	*/
	public function pushCriteria(Criteria $criteria)
	{
		$this->criteria->push($criteria);
		return $this;
	}

	/**
	* @return $this
	*/
	public function applyCriteria()
	{
		if($this->skipCriteria === true)
			return $this;

		foreach($this->getCriteria() as $criteria) {
			if($criteria instanceof Criteria)
				$this->model = $criteria->apply($this->model, $this);
		}

		return $this;
	}

}