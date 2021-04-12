<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "expr('/api/products' ~ object.getId())"
 *      )
 * )
 *@Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "get_one_product",
 *          parameters = { "id" = "expr(object.getId())" }
 *      )
 * )
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 *
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("post:read")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups("post:read")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     */
    private $date_c;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     */
    private $date_m;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("post:read")
     */
    private $product_type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $cover;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("post:read")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups("post:read")
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     */
    private $quantity;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("post:read")
     */
    private $api_links;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getDateM(): ?\DateTimeInterface
    {
        return $this->date_m;
    }

    public function setDateM(\DateTimeInterface $date_m): self
    {
        $this->date_m = $date_m;

        return $this;
    }

    public function getProductType(): ?string
    {
        return $this->product_type;
    }

    public function setProductType(string $product_type): self
    {
        $this->product_type = $product_type;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): self
    {
        $this->images = $images;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getApiLinks(): ?string
    {
        return $this->api_links;
    }

    public function setApiLinks(?string $api_links): self
    {
        $this->api_links = $api_links;

        return $this;
    }
}
