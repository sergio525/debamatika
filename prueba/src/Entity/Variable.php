<?php

namespace App\Entity;

use App\Entity\Admin\TipoCampo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariableRepository")
 */
class Variable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin\tipoCampo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoCampo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $valorDefecto;

    /**
     * @ORM\Column(type="integer")
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campo", inversedBy="variables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipoCampo(): ?TipoCampo
    {
        return $this->tipoCampo;
    }

    public function setTipoCampo(?TipoCampo $tipoCampo): self
    {
        $this->tipoCampo = $tipoCampo;

        return $this;
    }

    public function getValorDefecto(): ?string
    {
        return $this->valorDefecto;
    }

    public function setValorDefecto(?string $valorDefecto): self
    {
        $this->valorDefecto = $valorDefecto;

        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): self
    {
        $this->orden = $orden;

        return $this;
    }

    public function getCampo(): ?Campo
    {
        return $this->campo;
    }

    public function setCampo(?Campo $campo): self
    {
        $this->campo = $campo;

        return $this;
    }
}
