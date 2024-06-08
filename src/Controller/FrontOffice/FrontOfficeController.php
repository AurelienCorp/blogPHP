<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Constants;
use App\Controller\GlobalController;
use App\Repository\CategoryRepository;
use Exception;

abstract class FrontOfficeController extends GlobalController
{
	private readonly CategoryRepository $categoryRepository;

	public function __construct()
	{
		$this->categoryRepository = new CategoryRepository();
	}

	public function renderPage(string $content, $title = 'Rubrik a Brac')
	{
		$categories = $this->categoryRepository->findAll();

		if (isset($_SESSION['user'])) {
			$userLogedIn            = true;
			$hasRightAdministration = false;

			try {
				$hasRightAdministration = $this->checkRights($_SESSION['user']->getRole() ?? null, Constants::MODERATOR);
			} catch (Exception $e) {
				include 'src/Templates/WarningMessage.html';
			}
			if ($hasRightAdministration === true) {
				ob_start();
				require_once 'src/Templates/FooterAdministration.html';
				$footer = ob_get_clean();
			}
		} else {
			$userLogedIn = false;
			ob_start();
			require_once 'src/Templates/Footer.html';
			$footer = ob_get_clean();
		}

		ob_start();
		require_once 'src/Templates/Navigation.html';
		$nav = ob_get_clean();

		ob_start();
		require_once 'src/Templates/MainContainer.html';
		$page = ob_get_clean();

		$this->RenderVue($page, $title);
	}
}