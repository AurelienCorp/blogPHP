<?php

declare(strict_types=1);

namespace App\Controller\FrontOffice;

use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;

class PostController extends FrontOfficeController
{
	private readonly PostRepository $postRepository;
	private readonly CommentsRepository $commentRepository;
	private readonly UserRepository $userRepository;

	public function __construct()
	{
		$this->postRepository    = new PostRepository();
		$this->commentRepository = new CommentsRepository();
		$this->userRepository    = new UserRepository();
		parent::__construct();
	}

	public function showOnePost(int $postId): void
	{
		$post            = $this->postRepository->find($postId);
		$comments        = $this->commentRepository->findBy(['post_id' => $postId, 'state' => 'validated']);
		$commentUserName =[];

		foreach ($comments as $comment) {
			$userId                   = $comment->getUserId();
			$userName                 = $this->userRepository->find($userId)->getPseudo();
			$commentUserName[$userId] = $userName;
		}
		ob_start();
		require_once 'src/Templates/Article.html';
		$content = ob_get_clean();

		$title = 'RBAB Article ' . substr($post->getTitle(), 0, 50);
		$this->renderPage($content, $title);
	}

	public function showAllPosts(): void
	{
		$posts = $this->postRepository->findAll();

		ob_start();
		require_once 'src/Templates/HomeContent.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB Tous les articles');
	}

	public function showAllPostsByCategory(int $categoryId): void
	{
		$posts = $this->postRepository->findBy(['category_id' => $categoryId]);

		ob_start();
		require_once 'src/Templates/HomeContent.html';
		$content = ob_get_clean();

		$categoryRepository = new CategoryRepository();
		$categoryName       = $categoryRepository->find($categoryId)->getName();

		$title              = 'RBAB Articles : ' . $categoryName;
		$this->renderPage($content, $title);
	}
}