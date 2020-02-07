<?php

declare(strict_types=1);

namespace Root\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

/**
 * @Entity()
 */
class Skill
{
    /**
     * @Id()
     * @Column(type="integer")
     * @GeneratedValue()
     */
    private $id;

    /**
     * @Column()
     */
    private $name;

    /**
     * @Column()
     */
    private $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getValues(): array
    {
        return get_object_vars($this);
    }
}