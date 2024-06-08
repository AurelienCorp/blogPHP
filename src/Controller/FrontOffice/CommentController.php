<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Entity\CommentEntity;
use App\Entity\EntityManager;
use App\Repository\CommentsRepository;
use Exception;

class CommentController extends FrontOfficeController
{
	private readonly CommentsRepository $commentRepository;
	private readonly EntityManager $entityManager;

	public function __construct()
	{
		$this->commentRepository = new CommentsRepository();
		$this->entityManager     = new EntityManager();
		parent::__construct();
	}

	public function addComment()
	{
		$user = $_SESSION['user'];

		if (!hash_equals($_SESSION['token'], $_POST['token'])) {
			throw new Exception('le token ne correspond pas à celui de la session utilisateur');
		}

		$comment = $_POST['add_comment'];
		if (isset($comment) && is_string($comment) && $comment !== '') {
			$newComment = new CommentEntity();
			$newComment->setUserId($user->getId());
			$newComment->setPostId((int) $_POST['post_id']);
			$newComment->setContent($comment);
		} else {
			$_SESSION['empty_comment'] = true;
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$em = new EntityManager();
		$em->persist($newComment);

		$em->flush();

		$_SESSION['comment_added'] = true;
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}

	public function removeComment(int $commentId)
	{
		$comment = $this->commentRepository->find($commentId);

		$this->entityManager->removeFromDatabase($comment);
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}
}