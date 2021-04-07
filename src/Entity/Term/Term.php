<?php

namespace App\Entity\Term;

use App\Repository\Term\TermRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\EntityInterface;

/**
 * @ORM\Entity(repositoryClass=TermRepository::class)
 */
class Term implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"term:create","term:get"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $totalCount;

    /**
     * @Groups({"term:get"})
     */
    private $score;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotNull()
     * @Assert\Type("DateTimeInterface")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function setTotalCount(int $count) : self
    {
        $this->totalCount = $count;

        return $this;
    }

    public function getTotalCount() : ?int
    {
        return $this->totalCount;        
    }

    public function getScore(): ?float
    {
        return number_format($this->score, 2);
    }

    public function setScore(float $score): self
    {
        $this->score = $score;

        return $this;
    }
}
