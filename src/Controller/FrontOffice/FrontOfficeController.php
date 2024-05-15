<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Controller\GlobalController;
use App\Repository\CategoryRepository;

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
			$userLogedIn = true;
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

		$this->RenderVue($page);
	}
}