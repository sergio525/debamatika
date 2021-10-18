<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProtocoloRepository")
 */
class Protocolo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bloque", mappedBy="protocolo", orphanRemoval=true)
     */
    private $bloques;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TipoEquipo", inversedBy="protocolo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoEquipo;

    
    public function __construct()
    {
        $this->bloques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Bloque[]
     */
    public function getBloques(): Collection
    {
        return $this->bloques;
    }

    public function addBloque(Bloque $bloque): self
    {
        if (!$this->bloques->contains($bloque)) {
            $this->bloques[] = $bloque;
            $bloque->setProtocolo($this);
        }

        return $this;
    }

    public function removeBloque(Bloque $bloque): self
    {
        if ($this->bloques->contains($bloque)) {
            $this->bloques->removeElement($bloque);
            // set the owning side to null (unless already changed)
            if ($bloque->getProtocolo() === $this) {
                $bloque->setProtocolo(null);
            }
        }

        return $this;
    }

    public function getOrdenNuevo(){
        $maxOrden = 0;
        foreach ($this->getBloques() as $bloque){
            if ($bloque->getOrden() > $maxOrden){
                $maxOrden = $bloque->getOrden();
            }
        }
        
        return $maxOrden + 1;
    }

    public function getTipoEquipo(): ?TipoEquipo
    {
        return $this->tipoEquipo;
    }

    public function setTipoEquipo(TipoEquipo $tipoEquipo): self
    {
        $this->tipoEquipo = $tipoEquipo;

        return $this;
    }
}
