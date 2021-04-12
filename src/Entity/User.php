<?php

namespace App\Entity;


use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;


/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "get_users"
 *      )
 * )
 *@Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "get_user",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     * @SWG\Property(description="The unique identifier of the user.")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("post:read")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("post:read")
     */
    private $firstname;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("post:read")
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups("post:read")
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     */
    private $date_c;

    /**
     * @ORM\ManyToOne(targetEntity=Customers::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("post:read")
     */
    private $fk_custom;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateC(): ?\DateTimeInterface
    {
        return $this->date_c;
    }

    public function setDateC(\DateTimeInterface $date_c): self
    {
        $this->date_c = $date_c;

        return $this;
    }

    public function getFkCustom(): ?Customers
    {
        return $this->fk_custom;
    }

    public function setFkCustom(?Customers $fk_custom): self
    {
        $this->fk_custom = $fk_custom;

        return $this;
    }

    public function __construct()
    {
        $timezone = new \DateTimeZone('Europe/Paris');
        $time = new \DateTime('now', $timezone);
        $this->setDateC($time);


    }
}
