<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use App\Repository\CommentsRepository;

class CommentEntity extends Entity
{
	private ?int $id = null;
	private ?string $created_at;
	private ?string $updated_at;
	private string $content;
	private string $state;
	private int $user_id;
	private int $post_id;

	public function __construct()
	{
		$this->created_at =date('Y-m-d');
		$this->updated_at =date('Y-m-d');
		$this->state      ='pending';
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCreatedAt(): ?string
	{
		return $this->created_at;
	}

	public function setCreatedAt(string $created_at): self
	{
		$this->created_at = $created_at;

		return $this;
	}

	public function getUpdatedAt(): ?string
	{
		return $this->updated_at;
	}

	public function setUpdatedAt(string $updated_at): self
	{
		$this->updated_at = $updated_at;

		return $this;
	}

	public function getContent(): ?string
	{
		return $this->content;
	}

	public function setContent(string $content)
	{
		$this->content = $content;

		return $this;
	}

	public function getState(): ?string
	{
		return $this->state;
	}

	public function setState(string $state)
	{
		$this->state = $state;

		return $this;
	}

	public function getUserId(): ?int
	{
		return $this->user_id;
	}

	public function setUserId(int $user_id): self
	{
		$this->user_id = $user_id;

		return $this;
	}

	public function getPostId(): ?int
	{
		return $this->post_id;
	}

	public function setPostId(int $post_id): self
	{
		$this->post_id = $post_id;

		return $this;
	}

	protected function getEntityProperties(): array
	{
		return get_object_vars($this);
	}

	public function getDataBaseTableName(): string
	{
		return 'comment';
	}

	public function getRepository(): CommentsRepository
	{
		return new CommentsRepository();
	}
}
