<?php namespace Gr8abbasi\Repository\Criteria;

use Gr8abbasi\Repository\Contracts\RepositoryInterface;
use Gr8abbasi\Repository\Eloquent\AbstractRepository;

abstract class Criteria
{
	/**
	* Abstract Method to apply criteria
	* 
	* @param $model
	* @param Repository $repository
	*
	* @return $mixed
	*/
	public abstract function apply($model, AbstractRepository $repository);
}