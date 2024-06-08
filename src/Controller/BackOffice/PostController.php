<?php

declare(strict_types=1);

namespace App\Controller\BackOffice;

use App\Entity\EntityManager;
use App\Entity\PostEntity;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Exception;

class PostController extends BackOfficeController
{
	public function createPost()
	{
		$categoryReposytory = new CategoryRepository();
		$categories         = $categoryReposytory->findAll();

		ob_start();
		require_once 'src/Templates/CreatePost.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB création d\'article');
	}

	public function addPost()
	{
		$mandatoryData = ['chapo', 'title', 'user', 'category', 'content'];
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

		$_SESSION['addArticle_error'] = [];
		if (!empty($missingData)) {
			foreach ($mandatoryData as $property) {
				$_SESSION['addArticle_error'][$property] = $_POST[$property];
			}
			array_push($_SESSION['addArticle_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$newPost = new PostEntity();
		$newPost->setTitle($_POST['title']);
		$newPost->setChapo($_POST['chapo']);
		$newPost->setCreatedAt(date('Y-m-d'));
		$newPost->setUpdatedAt(date('Y-m-d'));
		$newPost->setCategoryId((int) $_POST['category']);
		$newPost->setUserId((int) $_POST['user']);
		$newPost->setContent($_POST['content']);
		$em = new EntityManager();
		$em->persist($newPost);

		$em->flush();

		$_SESSION['addArticle_succes'] = true;

		header('Location: ./', true, 302);
		exit;
	}

	public function showListPost()
	{
		$postRepository = new PostRepository();
		$posts          = $postRepository->findAll();

		ob_start();
		require_once 'src/Templates/ListPost.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB création d\'article');
	}

	public function updatePost(int $postId)
	{
		$postReposytory     = new PostRepository();
		$categoryReposytory = new CategoryRepository();

		$categories         = $categoryReposytory->findAll();
		$post               = $postReposytory->find($postId);

		ob_start();
		require_once 'src/Templates/UpdatePost.html';
		$content = ob_get_clean();

		$this->renderPage($content, 'RBAB création d\'article');
	}

	public function patchPost()
	{
		$mandatoryData = ['chapo', 'title', 'user', 'category', 'content'];
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

		$_SESSION['addArticle_error'] = [];
		if (!empty($missingData)) {
			foreach ($mandatoryData as $property) {
				$_SESSION['addArticle_error'][$property] = $_POST[$property];
			}
			array_push($_SESSION['addArticle_error'], ...$missingData);
			header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
			exit;
		}

		$postReposytory     = new PostRepository();
		$post               = $postReposytory->find((int) $_POST['postId']);
		$post->setTitle($_POST['title']);
		$post->setChapo($_POST['chapo']);
		$post->setCategoryId((int) $_POST['category']);
		$post->setContent($_POST['content']);

		$post->setUpdatedAt(date('Y-m-d'));
		$post->setCreatedAt($post->getCreatedAt());
		$post->setUserId($post->getUserId());

		$em = new EntityManager();
		$em->persist($post);

		$em->flush();

		$_SESSION['patchPost_succes'] = true;
		header('location: ' . $_SERVER['HTTP_REFERER'], true, 302);
		exit;
	}
}