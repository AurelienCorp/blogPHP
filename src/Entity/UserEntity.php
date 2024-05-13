<?php

namespace App\Entity;

use App\Entity\Abstracts\Entity;
use App\Repository\UserRepository;

class UserEntity extends Entity
{
	private ?int $id           = null;
	private ?string $email     = null;
	private ?string $pseudo    = null;
	private ?string $password  = null;
	private ?string $logo      = null;
	private ?string $firstname = null;
	private ?string $lastname  = null;
	private ?string $role      = null;

	public function __construct()
	{
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getPseudo(): ?string
	{
		return $this->pseudo;
	}

	public function setPseudo(string $pseudo): self
	{
		$this->pseudo = $pseudo;

		return $this;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	public function getLogo(): ?string
	{
		return $this->logo;
	}

	public function setLogo(string $logo): self
	{
		$this->logo = $logo;

		return $this;
	}

	public function getFirstname(): ?string
	{
		return $this->firstname;
	}

	public function setFirstname(string $firstname): self
	{
		$this->firstname = $firstname;

		return $this;
	}

	public function getLastname(): ?string
	{
		return $this->lastname;
	}

	public function setLastname(string $lastname): self
	{
		$this->lastname = $lastname;

		return $this;
	}

	public function getRole(): ?string
	{
		return $this->role;
	}

	public function setRole(string $role): self
	{
		$this->role = $role;

		return $this;
	}

	protected function getEntityProperties(): array
	{
		return get_object_vars($this);
	}

	public function getDataBaseTableName(): string
	{
		return 'user';
	}

	public function getRepository(): UserRepository
	{
		return new UserRepository();
	}
}
