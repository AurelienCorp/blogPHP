<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;

abstract class AbstractController
{
	private readonly CategoryRepository $categoryRepository;

	public function __construct()
	{
		$this->categoryRepository = new CategoryRepository();
	}

	public function renderPage(string $content)
	{
		$categories = $this->categoryRepository->findAll();

		ob_start();
		require_once 'src/Templates/Navigation.html';
		$nav = ob_get_clean();

		require_once 'src/Templates/MainContainer.html';
		require_once 'src/Templates/Footer.html';
	}
}