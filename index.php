<?php

require_once 'vendor/autoload.php';

use App\Constants;
use App\Router\Router;
use Dotenv\Dotenv;

session_start();
if (empty($_SESSION['token'])) {
	$_SESSION['token'] = bin2hex(random_bytes(32));
}

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router($_GET['url']);
$router->get('/', 'FrontOffice#HomePageController#index');
$router->get('/article/:id', 'FrontOffice#PostController#showOnePost');
$router->get('/articles/tous-les-articles', 'FrontOffice#PostController#showAllPosts');
$router->get('/articles/categorie-:id', 'FrontOffice#PostController#showAllPostsByCategory');
$router->get('/posts/:id', 'FrontOffice#HomePageController#index');
$router->post('/contact', 'FrontOffice#ContactController#sendContactForm');
$router->post('/add-user', 'FrontOffice#UserController#add');
$router->post('/connexion', 'FrontOffice#AuthenticationController#logIn');
$router->get('/deconnexion', 'FrontOffice#AuthenticationController#logOut');
$router->post('/ajouter-commentaire', 'FrontOffice#CommentController#addComment', null, true, Constants::SUBSCRIBER);
$router->get('/retirer-commentaire/:id', 'FrontOffice#CommentController#removeComment', null, true, Constants::SUBSCRIBER);
$router->get('/administration', 'BackOffice#HomePageController#index', null, true, Constants::MODERATOR);
$router->get('/administration/valider-commentaire/:id', 'BackOffice#CommentController#validateComment', null, true, Constants::MODERATOR);
$router->get('/administration/rejeter-commentaire/:id', 'BackOffice#CommentController#rejectComment', null, true, Constants::MODERATOR);
$router->get('/administration/creer-article', 'BackOffice#PostController#createPost', null, true, Constants::ADMIN);
$router->post('/administration/ajouter-article', 'BackOffice#PostController#addPost', null, true, Constants::ADMIN);
$router->get('/administration/liste-article', 'BackOffice#PostController#showListPost', null, true, Constants::ADMIN);
$router->get('/administration/modifier-article/:id', 'BackOffice#PostController#updatePost', null, true, Constants::ADMIN);
$router->post('/administration/modifier-article', 'BackOffice#PostController#patchPost', null, true, Constants::ADMIN);

try {
	$router->run();
} catch (\Throwable $error) {
	include_once './src/templates/Error404.html';
}