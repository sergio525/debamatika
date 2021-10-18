<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VariableInformeRepository")
 */
class VariableInforme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Informe", inversedBy="variables")
     * @ORM\JoinColumn(nullable=false)
     */
    private $informe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Variable")
     * @ORM\JoinColumn(nullable=false)
     */
    private $variable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $valor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInforme(): ?Informe
    {
        return $this->informe;
    }

    public function setInforme(?Informe $informe): self
    {
        $this->informe = $informe;

        return $this;
    }

    public function getVariable(): ?Variable
    {
        return $this->variable;
    }

    public function setVariable(?Variable $variable): self
    {
        $this->variable = $variable;

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

    public function getValor(): ?string
    {
        return $this->valor;
    }

    public function setValor(string $valor): self
    {
        $this->valor = $valor;

        return $this;
    }
}
