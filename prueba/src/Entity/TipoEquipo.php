<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TipoEquipoRepository")
 */
class TipoEquipo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipo", mappedBy="tipo", orphanRemoval=true)
     */
    private $equipos;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Protocolo", mappedBy="tipoEquipo", cascade={"persist", "remove"})
     */
    private $protocolo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EquipoInstalado", mappedBy="tipoEquipo", orphanRemoval=true)
     */
    private $equipoInstalados;

    public function __construct()
    {
        $this->equipos = new ArrayCollection();
        $this->equipoInstalados = new ArrayCollection();
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

    /**
     * @return Collection|Equipo[]
     */
    public function getEquipos(): Collection
    {
        return $this->equipos;
    }

    public function addEquipo(Equipo $equipo): self
    {
        if (!$this->equipos->contains($equipo)) {
            $this->equipos[] = $equipo;
            $equipo->setTipo($this);
        }

        return $this;
    }

    public function removeEquipo(Equipo $equipo): self
    {
        if ($this->equipos->contains($equipo)) {
            $this->equipos->removeElement($equipo);
            // set the owning side to null (unless already changed)
            if ($equipo->getTipo() === $this) {
                $equipo->setTipo(null);
            }
        }

        return $this;
    }

    public function getProtocolo(): ?Protocolo
    {
        return $this->protocolo;
    }

    public function setProtocolo(Protocolo $protocolo): self
    {
        $this->protocolo = $protocolo;

        // set the owning side of the relation if necessary
        if ($protocolo->getTipoEquipo() !== $this) {
            $protocolo->setTipoEquipo($this);
        }

        return $this;
    }

    /**
     * @return Collection|EquipoInstalado[]
     */
    public function getEquipoInstalados(): Collection
    {
        return $this->equipoInstalados;
    }

    public function addEquipoInstalado(EquipoInstalado $equipoInstalado): self
    {
        if (!$this->equipoInstalados->contains($equipoInstalado)) {
            $this->equipoInstalados[] = $equipoInstalado;
            $equipoInstalado->setTipoEquipo($this);
        }

        return $this;
    }

    public function removeEquipoInstalado(EquipoInstalado $equipoInstalado): self
    {
        if ($this->equipoInstalados->contains($equipoInstalado)) {
            $this->equipoInstalados->removeElement($equipoInstalado);
            // set the owning side to null (unless already changed)
            if ($equipoInstalado->getTipoEquipo() === $this) {
                $equipoInstalado->setTipoEquipo(null);
            }
        }

        return $this;
    }
}
