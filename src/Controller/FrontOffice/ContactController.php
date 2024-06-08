<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Entity\ContactFormEntity;
use App\Entity\EntityManager;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactController extends FrontOfficeController
{
	public function __construct()
	{
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

		$contactForm = new ContactFormEntity();
		$contactForm->setEmail($_POST['recipient-email']);
		$contactForm->setFirstName($_POST['recipient-firstName']);
		$contactForm->setLastName($_POST['recipient-lastName']);
		$contactForm->setMessage($_POST['message-text']);
		$contactForm->setSendAt(date('Y-m-d'));

		$em = new EntityManager();
		$em->persist($contactForm);

		$em->flush();

		$debug = true;

		try {
			// Créer une instance de classe PHPMailer
			$mail = new PHPMailer($debug);
			if ($debug) {
				// donne un journal détaillé
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;
			}
			// Authentification via SMTP
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			// Connexion
			$mail->Host       = 'smtp.gmail.com';
			$mail->Port       = 587;
			$mail->Username   = 'rubrik.a.brak.php@gmail.com';
			$mail->Password   = $_ENV['MAILER_PASSWORD'];
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->setFrom($_POST['recipient-email'], $_POST['recipient-firstName'] . ' ' . $_POST['recipient-lastName']);
			$mail->addAddress('rubrik.a.brak.php@gmail.com', 'Rubrik A Brak');
			$mail->CharSet  = 'UTF-8';
			$mail->Encoding = 'base64';
			$mail->isHTML(true);
			$mail->Subject = 'Demande de contact de ' . $_POST['recipient-firstName'] . ' ' . $_POST['recipient-lastName'];
			$mail->Body    = $_POST['message-text'];
			$mail->send();
		} catch (Exception $e) {
			echo "La demande de contact n'a pas pu être envoyée. Erreur d'envoit de mail: " . $e->getMessage();
		}

		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
	}
}