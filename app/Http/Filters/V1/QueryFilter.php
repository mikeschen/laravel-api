<?php

namespace App\Http\Filters\V1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
	protected $builder;
	protected $request;

	public function __construct(Request $request) {
		$this->request = $request;
	}

	public function apply(Builder $builder) {
		$this->builder = $builder;

		foreach($this->request->all() as $key => $value) {
			if (method_exists($this, $key)) {
				$this->$key($value);
			}
		}

		return $builder;
	}

	protected function filter($arr) {
		foreach($arr as $key => $value) {
			if (method_exists($this, $key)) {
				$this->$key($value);
			}
		}
	}

	protected function sort($value) {
		$sortAttributes = explode(',', $value);

		foreach($sortAttributes as $sortAttribute) {
			$direction = 'asc';

			if (substr($sortAttribute, 0, 1) == '-') {
				$direction = 'desc';
				$sortAttribute = substr($sortAttribute, 1);
			}

			$this->builder->orderBy($sortAttribute, $direction);
		}
	}
}