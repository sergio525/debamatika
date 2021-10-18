<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstalacionRepository")
 */
class Instalacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $descripcion;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cliente", inversedBy="instalaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EquipoInstalado", mappedBy="instalacion", orphanRemoval=true)
     */
    private $equiposInstalados;

    public function __construct()
    {
        $this->equiposInstalados = new ArrayCollection();
    }

    public function __toString() {
        return $this->descripcion;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * @return Collection|EquipoInstalado[]
     */
    public function getEquiposInstalados(): Collection
    {
        return $this->equiposInstalados;
    }

    public function addEquiposInstalado(EquipoInstalado $equiposInstalado): self
    {
        if (!$this->equiposInstalados->contains($equiposInstalado)) {
            $this->equiposInstalados[] = $equiposInstalado;
            $equiposInstalado->setInstalacion($this);
        }

        return $this;
    }

    public function removeEquiposInstalado(EquipoInstalado $equiposInstalado): self
    {
        if ($this->equiposInstalados->contains($equiposInstalado)) {
            $this->equiposInstalados->removeElement($equiposInstalado);
            // set the owning side to null (unless already changed)
            if ($equiposInstalado->getInstalacion() === $this) {
                $equiposInstalado->setInstalacion(null);
            }
        }

        return $this;
    }
}
