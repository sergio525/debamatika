<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InformeRepository")
 */
class Informe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroRevision;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroPedido;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipoInstalado", inversedBy="informes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VariableInforme", mappedBy="informe", orphanRemoval=true)
     */
    private $variables;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Anotacion", mappedBy="informe", orphanRemoval=true)
     */
    private $anotaciones;

    public function __construct()
    {
        $this->variables = new ArrayCollection();
        $this->anotaciones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroRevision(): ?int
    {
        return $this->numeroRevision;
    }

    public function setNumeroRevision(int $numeroRevision): self
    {
        $this->numeroRevision = $numeroRevision;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getNumeroPedido(): ?string
    {
        return $this->numeroPedido;
    }

    public function setNumeroPedido(string $numeroPedido): self
    {
        $this->numeroPedido = $numeroPedido;

        return $this;
    }

    public function getEquipo(): ?EquipoInstalado
    {
        return $this->equipo;
    }

    public function setEquipo(?EquipoInstalado $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    /**
     * @return Collection|VariableInforme[]
     */
    public function getVariables(): Collection
    {
        return $this->variables;
    }

    public function addVariable(VariableInforme $variable): self
    {
        if (!$this->variables->contains($variable)) {
            $this->variables[] = $variable;
            $variable->setInforme($this);
        }

        return $this;
    }

    public function removeVariable(VariableInforme $variable): self
    {
        if ($this->variables->contains($variable)) {
            $this->variables->removeElement($variable);
            // set the owning side to null (unless already changed)
            if ($variable->getInforme() === $this) {
                $variable->setInforme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Anotacion[]
     */
    public function getAnotaciones(): Collection
    {
        return $this->anotaciones;
    }

    public function addAnotacione(Anotacion $anotacione): self
    {
        if (!$this->anotaciones->contains($anotacione)) {
            $this->anotaciones[] = $anotacione;
            $anotacione->setInforme($this);
        }

        return $this;
    }

    public function removeAnotacione(Anotacion $anotacione): self
    {
        if ($this->anotaciones->contains($anotacione)) {
            $this->anotaciones->removeElement($anotacione);
            // set the owning side to null (unless already changed)
            if ($anotacione->getInforme() === $this) {
                $anotacione->setInforme(null);
            }
        }

        return $this;
    }
}
