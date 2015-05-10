<?php namespace Gr8abbasi\Repository\Contracts;

use Gr8abbasi\Repository\Criteria\Criteria;

/**
* Interface CriteriaInterface
* @package Gr8abbasi\Repository\Contracts
*/
interface CriteriaInterface 
{
	/**
	* Reset Criteria to false
	* 
	* @return $this
	*/
	public function resetScope();

	/**
	* Skip Criteria status
	* 
	* @param string $status
	* @return $this
	*/
	public function skipCriteria($status = true);

	/**
	* Get Criteria object
	* 
	* @return mixed
	*/
	public function getCriteria();

	/**
	* Get Criteria apply
	* 
	* @param Criteria $criteria
	* @return $this
	*/
	public function getByCriteria(Criteria $criteria);

	/**
	* Push Criteria
	* 
	* @param Criteria $criteria
	* @return $this
	*/
	public function pushCriteria(Criteria $criteria);

	/**
	* Apply Criteria
	* 
	* @return $this
	*/
	public function applyCriteria();
}