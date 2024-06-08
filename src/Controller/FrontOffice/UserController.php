<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Entity\EntityManager;
use App\Entity\UserEntity;
use App\Repository\UserRepository;
use Exception;

class UserController extends FrontOfficeController
{
	private readonly UserRepository $userRepository;
	private readonly AuthenticationController $authenticationController;

	public function __construct()
	{
		$this->userRepository           = new UserRepository();
		$this->authenticationController = new AuthenticationController();
		parent::__construct();
	}

	public function add(): void
	{
		$mandatoryData = ['email', 'pseudo', 'password', 'firstname', 'lastname'];
		$missingData   = [];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		foreach ($mandatoryData as $property) {
			if (!isset($_POST[$property]) || !is_string($_POST[$property]) || $_POST[$property] === '') {
				if ($property === 'password' && strlen($_POST[$property]) < 6) {
					$missingData[] = $property;

					continue;
				}
				$missingData[] = $property;
			}
		}
		$_SESSION['subscribe_error'] = [];
		if (!empty($missingData)) {
			foreach ($mandatoryData as $property) {
				$_SESSION['subscribe_error'][$property] = $_POST[$property];
			}
			array_push($_SESSION['subscribe_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$userExist = $this->userRepository->findOneBy(['email' => $_POST['email']]);
		if ($userExist) {
			foreach ($mandatoryData as $property) {
				$_SESSION['subscribe_error'][$property] = $_POST[$property];
			}
			array_push($_SESSION['subscribe_error'], 'email_already_used');
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$user = new UserEntity();
		$user->setEmail($_POST['email']);
		$user->setPseudo($_POST['pseudo']);

		$hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$user->setPassword($hashed_password);

		$user->setFirstname($_POST['firstname']);
		$user->setLastname($_POST['lastname']);

		$user->setRole('subscriber');

		$em = new EntityManager();
		$em->persist($user);

		try {
			$userId = $em->flush();
		} catch (\Throwable $th) {
			$_SESSION['user_flush_error'] = true;
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}
		$_SESSION['subscribe_success']       = true;
		$_SESSION['subscriber_pseudo']       = $_POST['pseudo'];

		$user             = $this->userRepository->find($userId);

		$this->authenticationController->startUserSession($user);
	}
}