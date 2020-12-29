<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table (name="contents")
 * @ORM\Entity(repositoryClass=ContentRepository::class)
 */
class Content
{
    use ModifyEntityTrait;

    /**
     * @ORM\Column(type="identifier")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=SubscriptionType::class, mappedBy="content")
     */
    private $subscriptionTypes;

    public function __construct()
    {
        $this->subscriptionTypes = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|SubscriptionType[]
     */
    public function getSubscriptionTypes(): Collection
    {
        return $this->subscriptionTypes;
    }

    public function addSubscriptionType(SubscriptionType $subscriptionType): self
    {
        if (!$this->subscriptionTypes->contains($subscriptionType)) {
            $this->subscriptionTypes[] = $subscriptionType;
            $subscriptionType->addContent($this);
        }

        return $this;
    }

    public function removeSubscriptionType(SubscriptionType $subscriptionType): self
    {
        if ($this->subscriptionTypes->removeElement($subscriptionType)) {
            $subscriptionType->removeContent($this);
        }

        return $this;
    }
}