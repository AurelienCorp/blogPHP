<?php

declare(strict_types=1);

namespace App\Controller\BackOffice;

use App\Controller\GlobalController;

abstract class BackOfficeController extends GlobalController
{
	public function renderPage(string $content, $title = 'Rubrik a Brac')
	{
		ob_start();
		$from = 'backOffice';
		require_once 'src/Templates/FooterAdministration.html';
		$footer = ob_get_clean();

		ob_start();
		require_once 'src/Templates/NavigationBack.html';
		$nav = ob_get_clean();

		ob_start();
		require_once 'src/Templates/MainContainerBack.html';
		$page = ob_get_clean();

		$this->RenderVue($page, $title);
	}
}