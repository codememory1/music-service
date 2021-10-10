<?php

namespace App\Orm\Entities;

use Codememory\Components\Database\Orm\Constructions as ORM;

/**
 * Class UserEntity
 *
 * @package App\Orm\Entities
 *
 * @author  Danil
 */
#[ORM\Entity(tableName: 'users')]
#[ORM\Repository(repository: 'App\Orm\Repositories\UserRepository')]
class UserEntity
{

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'id', type: 'int', length: null, nullable: false)]
    #[ORM\Identifier]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'name', type: 'varchar', length: 32, nullable: false)]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'email', type: 'varchar', length: 255, nullable: false)]
    private ?string $email = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'username', type: 'varchar', length: 255, nullable: false)]
    private ?string $username = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'password', type: 'text', length: null, nullable: false)]
    private ?string $password = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'surname', type: 'varchar', length: 32, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $surname = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'patronymic', type: 'varchar', length: 32, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $patronymic = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'birth', type: 'date', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?string $birth = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'subscription', type: 'int', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'NULL')]
    private ?int $subscription = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'role', type: 'int', length: null, nullable: false)]
    #[ORM\DefaultValue(value: '1')]
    #[ORM\Reference(entity: RoleEntity::class, referencedColumnName: 'id')]
    private ?int $role = null;

    /**
     * @var int|null
     */
    #[ORM\Column(name: 'status', type: 'int', length: null, nullable: false)]
    #[ORM\DefaultValue(value: '0')]
    private ?int $status = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'created_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $created_at = null;

    /**
     * @var string|null
     */
    #[ORM\Column(name: 'updated_at', type: 'datetime', length: null, nullable: true)]
    #[ORM\DefaultValue(value: 'CURRENT_TIMESTAMP')]
    private ?string $updated_at = null;

    /**
     * @var SubscriptionEntity|null
     */
    private ?SubscriptionEntity $subscriptionData = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * @param string $name
     *
     * @return UserEntity
     */
    public function setName(string $name): static
    {

        $this->name = $name;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {

        return $this->name;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setEmail(string $value): static
    {

        $this->email = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {

        return $this->email;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setUsername(string $value): static
    {

        $this->username = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {

        return $this->username;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setPassword(string $value): static
    {

        $this->password = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {

        return $this->password;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setSurname(string $value): static
    {

        $this->surname = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {

        return $this->surname;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setPatronymic(string $value): static
    {

        $this->patronymic = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {

        return $this->patronymic;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setBirth(string $value): static
    {

        $this->birth = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getBirth(): ?string
    {

        return $this->birth;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setSubscription(int $value): static
    {

        $this->subscription = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getSubscription(): ?int
    {

        return $this->subscription;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setRole(int $value): static
    {

        $this->role = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getRole(): ?int
    {

        return $this->role;

    }

    /**
     * @param int $value
     *
     * @return static
     */
    public function setStatus(int $value): static
    {

        $this->status = $value;

        return $this;

    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {

        return $this->status;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setCreatedAt(string $value): static
    {

        $this->created_at = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getCreatedAt(): ?string
    {

        return $this->created_at;

    }

    /**
     * @param string $value
     *
     * @return static
     */
    public function setUpdatedAt(string $value): static
    {

        $this->updated_at = $value;

        return $this;

    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {

        return $this->updated_at;

    }

    /**
     * @param SubscriptionEntity $subscriptionEntity
     *
     * @return static
     */
    public function setSubscriptionData(SubscriptionEntity $subscriptionEntity): static
    {

        $this->subscriptionData = $subscriptionEntity;

        return $this;

    }

    /**
     * @return SubscriptionEntity|null
     */
    public function getSubscriptionData(): ?SubscriptionEntity
    {

        return $this->subscriptionData;

    }

}