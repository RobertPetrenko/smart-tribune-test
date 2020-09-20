<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Question
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_question"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_question", "update_question"})
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"show_question"})
     */
    private $promoted;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show_question", "update_question"})
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show_question"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show_question"})
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", orphanRemoval=true, cascade={"persist"})
     * @Groups({"show_question"})
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPromoted(): bool
    {
        return $this->promoted;
    }

    public function setPromoted(bool $promoted): self
    {
        $this->promoted = $promoted;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        if (!in_array($status, array(self::STATUS_DRAFT, self::STATUS_PUBLISHED))) {
            throw new \InvalidArgumentException("Invalid status. Use draft or published status");
        }
        $this->status = $status;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /** @ORM\PrePersist */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /** @ORM\PreUpdate */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new DateTime();
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);
            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }
}
