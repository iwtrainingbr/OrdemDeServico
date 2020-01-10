<?php

declare(strict_types=1);

namespace Root\Entity;

class Ticket
{
    private $id;
    private $attendant;
    private $expert;
    private $client;
    private $status;
    private $title;
    private $description;
    private $deadline;
    private $createdAt;
    private $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAttendant(): User
    {
        return $this->attendant;
    }

    public function setAttendant(User $attendant): void
    {
        $this->attendant = $attendant;
    }

    public function getExpert(): User
    {
        return $this->expert;
    }

    public function setExpert(User $expert): void
    {
        $this->expert = $expert;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(Client $client): void
    {
        $this->client = $client;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDeadline(): \DateTime
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTime $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}