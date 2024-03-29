<?php

namespace App\Entity;

use App\Repository\InvoiceLinesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvoiceLinesRepository::class)]
class InvoiceLines
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Invoice $invoice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2, nullable: true)]
    private ?string $vatAmount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 14, scale: 2)]
    private ?string $totalWithVat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getVatAmount(): ?string
    {
        return $this->vatAmount;
    }

    public function setVatAmount(?string $vatAmount): static
    {
        $this->vatAmount = $vatAmount;

        return $this;
    }

    public function getTotalWithVat(): ?string
    {
        return $this->totalWithVat;
    }

    public function setTotalWithVat(string $totalWithVat): static
    {
        $this->totalWithVat = $totalWithVat;

        return $this;
    }
}
