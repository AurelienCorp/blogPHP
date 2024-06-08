<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Entity\UserEntity;
use App\Repository\UserRepository;
use Exception;

class AuthenticationController extends FrontOfficeController
{
	private readonly UserRepository $userRepository;

	public function __construct()
	{
		$this->userRepository = new UserRepository();
		parent::__construct();
	}

	public function logIn(): void
	{
		$mandatoryData = ['email', 'password'];
		$missingData   = [];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		foreach ($mandatoryData as $property) {
			if (!isset($_POST[$property]) || !is_string($_POST[$property]) || $_POST[$property] === '') {
				$missingData[] = $property;
			}
		}

		if (!empty($missingData)) {
			$_SESSION['login_error'] = [];
			array_push($_SESSION['login_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$userEmail = $_POST['email'];

		$user = $this->userRepository->findOneBy(['email' => $userEmail]);
		if (!$user) {
			$_SESSION['login_error']          = [];
			$_SESSION['login_error']['email'] = $_POST['email'];
			array_push($_SESSION['login_error'], 'unknown_email');
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$storedPassword = $user->getPassword();
		if (password_verify($_POST['password'], $storedPassword)) {
			$this->startUserSession($user);
		} else {
			$_SESSION['login_error']          = [];
			$_SESSION['login_error']['email'] = $_POST['email'];
			array_push($_SESSION['login_error'], 'password');
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}
	}

	public function startUserSession(UserEntity $user)
	{
		session_destroy();
		session_start();
		$_SESSION['user']  = $user;
		$_SESSION['token'] = bin2hex(random_bytes(32));
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}

	public function logOut()
	{
		session_destroy();
		session_start();
		$_SESSION['token'] = bin2hex(random_bytes(32));
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}
}