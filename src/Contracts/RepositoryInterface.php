<?php namespace Gr8abbasi\Repository\Contracts;

/**
* Interface RepositoryInterface
* @package Gr8abbasi\Repository\Contracts
*/
interface RepositoryInterface {

	/*
	|--------------------------------------------------------------------------
	| RepositoryInterface
	|--------------------------------------------------------------------------
	|
	| This RepositryInterface will be implemented by Abstract Repository!
	|
	*/

	
    /**
     * Returns the array or mixed data from database.
     *
     * @param string|array $columns
     *
     * @return mixed
     */
	public function all($columns = array('*'));

     /**
     * Returns the array of lists (key=>value pairs) data from database.
     *
     * @param string $value
     * @param string $key
     *
     * @return array
     */
     public function lists($value, $key = null);

	/**
     * Returns paginated requested mix or array data from database.
     *
     * @param string|int $perPage
     * @param string|array $columns
     *
     * @return mixed
     */
	public function paginate($perPage = 10, $columns = array('*'));

	/**
     * Creates a new record in database.
     *
     * @param array $data
     *
     * @return mixed
     */
	public function create(array $data);

	/**
     * Updates a particular record in database using its ID.
     *
     * @param array $data
     * @param int|string $id
     *
     * @return mixed
     */
	public function update(array $data, $id);

	/**
     * Deletes a particular record in database using its ID.
     *
     * @param int|string $id
     *
     * @return mixed
     */
	public function delete($id);

	/**
     * Fetch specified columns for a particular record from database using its ID.
     *
     * @param int|string $id
     * @param array $columns
     *
     * @return mixed
     */
	public function find($id, $columns = array('*'));

	/**
     * Fetch specified columns for a particular record from database using its field's value.
     * e.g. Where username. 
     *
     * @param string $attribute
     * @param string $value
     * @param array $columns
     *
     * @return mixed
     */
	public function where($attribute, $value, $columns = array('*'));

     /**
     * To use eager loading provided by laravel we should have __call function to handle it
     * e.g. findByUsername. 
     *
     * @param string $method
     * @param mixed $args
     *
     * @return mixed
     */
     public function __call($method, $args);     
}