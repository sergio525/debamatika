<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlantillaRepository")
 */
class Plantilla
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EquipoInstalado", inversedBy="plantillas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $equipo;

    /**
     * @ORM\Column(type="integer")
     */
    private $idItem;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipoItem;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdItem(): ?int
    {
        return $this->idItem;
    }

    public function setIdItem(int $idItem): self
    {
        $this->idItem = $idItem;

        return $this;
    }

    public function getTipoItem(): ?string
    {
        return $this->tipoItem;
    }

    public function setTipoItem(string $tipoItem): self
    {
        $this->tipoItem = $tipoItem;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
}
