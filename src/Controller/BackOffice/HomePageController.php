<?php

namespace App\Controller\BackOffice;

use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class HomePageController extends BackOfficeController
{
	public function index()
	{
		$commentRepository = new CommentsRepository();
		$userRepository    = new UserRepository();
		$postRepository    = new PostRepository();
		$pendingComments   = $commentRepository->findBy(['state'=> 'pending']);

		$commentUserNames =[];

		foreach ($pendingComments as $comment) {
			$userId                                 = $comment->getUserId();
			$postId                                 = $comment->getPostId();
			$userName                               = $userRepository->find($userId)->getPseudo();
			$postTitle                              = $postRepository->find($postId)->getTitle();
			$commentUserNames['userName'][$userId]  = $userName;
			$commentUserNames['postTitle'][$postId] = $postTitle;
		}

		ob_start();
		require_once 'src/Templates/HomePageBack.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB Administration');
	}
}