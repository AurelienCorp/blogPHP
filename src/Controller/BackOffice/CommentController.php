<?php

declare(strict_types=1);

namespace App\Controller\BackOffice;

use App\Entity\EntityManager;
use App\Repository\CommentsRepository;

class CommentController extends BackOfficeController
{
	public function validateComment(int $commentId)
	{
		$commentRepository  = new CommentsRepository();
		$comment            = $commentRepository->find($commentId);

		$comment->setState('validated');
		$em = new EntityManager();
		$em->persist($comment);

		$em->flush();

		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}

	public function rejectComment(int $commentId)
	{
		$commentRepository  = new CommentsRepository();
		$comment            = $commentRepository->find($commentId);

		$em = new EntityManager();
		$em->removeFromDatabase($comment);
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}
}