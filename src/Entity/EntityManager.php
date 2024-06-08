<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use Exception;
use App\PDO\DataBaseConnection;
use DateTime;
use PDO;

class EntityManager
{
	private array $persistedRequests;

	public function persist(Entity $entity): void
	{
		$entityProperties          = $entity->getOrderedProperties();
		$this->persistedRequests[] = $entityProperties;
	}

	public function flush(): int
	{
		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();
		$dataBase->beginTransaction();

		foreach ($this->persistedRequests as $request) {
			$mode     = $request['mode'];
			$sqlQuery = $this->getSqlQuery($request, $mode);

			if ($sqlQuery === null) {
				throw new Exception('une erreur dans l\'enregristrement est survenue');
			}
			$query = $dataBase->prepare($sqlQuery);

			$this->formatRequest($request['values']);
			if ($mode === 'insert') {
				unset($request['values']['id']);
			}
			$query->execute($request['values']);
		}

		$rowId = $dataBase->lastInsertId();

		$error = $dataBase->commit();

		if (!$error) {
			$dataBase->rollBack();

			throw new Exception('une erreur est survenue lors de l\'enregistrement en base de donnée');
		}

		return $rowId;
	}

	public function removeFromDatabase(Entity $entity): void
	{
		if ($entity->getId() === null || empty($entity->getRepository()->find($entity->getId()))) {
			throw new Exception("Cette donnée ne peut pas être supprimé car elle n'est pas présente dans la base de donnée");
		}

		$dataBaseConnection = new DataBaseConnection();
		$dataBase           = $dataBaseConnection->connectToDataBase();

		$sqlQuery = "DELETE FROM {$entity->getDataBaseTableName()} WHERE id = :id";
		$query    = $dataBase->prepare($sqlQuery);
		$query->bindValue('id', $entity->getId(), PDO::PARAM_INT);

		$query->execute();
	}

	private function getSqlQuery(array $request, string $mode): string
	{
		if (count($request) === 0) {
			return null;
		}

		if ($mode === 'insert') {
			$columns = [];
			$values  = [];
			foreach ($request['properties'] as $key => $property) {
				if ($property === 'id') {
					continue;
				}
				$columns[] = $property;
				$values[]  = ':' . $property;
			}
			$sqlColumns = implode(',', $columns);
			$sqlValues  = implode(',', $values);
			$sqlQuery   = "INSERT INTO {$request['tableName']} ($sqlColumns) VALUES ($sqlValues)";
		} else {
			$updatedColumns = [];
			$i              = 0;
			foreach ($request['properties'] as $property) {
				if ($property === 'id') {
					continue;
				}
				$updatedColumns[] =  $property . '= :' . $property;
				++$i;
			}
			$setClause = implode(',', $updatedColumns);

			$sqlQuery = "UPDATE {$request['tableName']} SET $setClause WHERE id = :id";
		}

		return $sqlQuery;
	}

	private function formatRequest(array &$propertiesValues): array
	{
		foreach ($propertiesValues as $property => $value) {
			if ($value instanceof DateTime) {
				$propertiesValues[$property] = $value->format('Y-m-d');
			}
		}

		return $propertiesValues;
	}
}
