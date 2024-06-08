<?php

declare(strict_types=1);

namespace App\Controller;

use App\Constants;
use Exception;

abstract class GlobalController
{
	private array $roleOrder = [Constants::SUBSCRIBER => 1, Constants::MODERATOR => 2, Constants::ADMIN => 3, Constants::SUPERADMIN => 4];

	public function RenderVue($page, $title)
	{
		require_once 'src/Templates/GlobalTemplate.html';
	}

	public function checkRights($userRole = Constants::SUBSCRIBER, $minimalRoleRequired = Constants::SUPERADMIN): bool
	{
		if ($userRole === null) {
			throw new Exception("Vous n'avez pas de rôle défini, contactez un administrateur");
		}
		if (!is_string($_SESSION['user']->getRole()) || !array_key_exists($userRole, $this->roleOrder)) {
			throw new Exception('Rôle utilisateur inconnu, contactez un administrateur');
		}

		$userRoleValue            = $this->roleOrder[$userRole];
		$minimalRoleRequiredValue = $this->roleOrder[$minimalRoleRequired];

		if ((int) $userRoleValue < (int) $minimalRoleRequiredValue) {
			return false;
		}

		return true;
	}
}
