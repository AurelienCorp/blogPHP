<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Exception;

class ContactController extends AbstractController
{
	private readonly UserRepository $userRepository;
	private readonly AuthenticationController $authenticationController;

	public function __construct()
	{
		$this->userRepository           = new UserRepository();
		$this->authenticationController = new AuthenticationController();
		parent::__construct();
	}

	public function sendContactForm(): void
	{
		$mandatoryData = ['recipient-firstName', 'recipient-lastName', 'recipient-email', 'message-text'];
		$missingData   = [];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		foreach ($mandatoryData as $property) {
			if (!isset($_POST[$property]) || !is_string($_POST[$property]) || $_POST[$property] === '') {
				$missingData[] = $property;
			}
		}

		$_SESSION['contact_error'] = [];
		if (!empty($missingData)) {
			foreach ($mandatoryData as $property) {
				$_SESSION['contact_error'][$property] = $_POST[$property];
			}
			array_push($_SESSION['contact_error'], ...$missingData);

			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		mail('a.demblans@hotmail.fr', 'My subject', 'coucou le mail');
	}
}