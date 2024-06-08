<?php

namespace App\Entity\Abstracts;

use App\Repository\Abstracts\AbstractRepository;

abstract class Entity
{
	abstract public function getId(): ?int;

	abstract public function getDataBaseTableName(): string;

	abstract protected function getEntityProperties(): array;

	abstract public function getRepository(): AbstractRepository;

	public function getOrderedProperties()
	{
		$entityProps   = $this->getEntityProperties();
		$allProperties = ['properties' => [], 'values' => []];
		foreach ($entityProps as $key => $value) {
			$allProperties['properties'][] = $key;
			$allProperties['values'][$key] = $value;
		}
		$allProperties['tableName'] = $this->getDataBaseTableName();
		$allProperties['mode']      = $this->getId() === null ? 'insert' : 'update';

		return $allProperties;
	}
}
