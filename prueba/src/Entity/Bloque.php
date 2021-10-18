<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BloqueRepository")
 */
class Bloque
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
    private $titulo;

    /**
     * @ORM\Column(type="integer")
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Protocolo", inversedBy="bloques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $protocolo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ayuda;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Campo", mappedBy="bloque", orphanRemoval=true)
     */
    private $campos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Bloque", mappedBy="bloquePadre", orphanRemoval=true)
     */
    private $bloques;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bloque", inversedBy="bloques")
     */
    private $bloquePadre;
    
    public function __construct()
    {
        $this->campos = new ArrayCollection();
        $this->bloques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

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

    public function getProtocolo(): ?Protocolo
    {
        return $this->protocolo;
    }

    public function setProtocolo(?Protocolo $protocolo): self
    {
        $this->protocolo = $protocolo;

        return $this;
    }

    public function getAyuda(): ?string
    {
        return $this->ayuda;
    }

    public function setAyuda(?string $ayuda): self
    {
        $this->ayuda = $ayuda;

        return $this;
    }

    /**
     * @return Collection|campo[]
     */
    public function getCampos(): Collection
    {
        return $this->campos;
    }

    public function addCampo(campo $campo): self
    {
        if (!$this->campos->contains($campo)) {
            $this->campos[] = $campo;
            $campo->setBloque($this);
        }

        return $this;
    }

    public function removeCampo(campo $campo): self
    {
        if ($this->campos->contains($campo)) {
            $this->campos->removeElement($campo);
            // set the owning side to null (unless already changed)
            if ($campo->getBloque() === $this) {
                $campo->setBloque(null);
            }
        }

        return $this;
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
            $bloque->setBloquePadre($this);
        }

        return $this;
    }

    public function removeBloque(Bloque $bloque): self
    {
        if ($this->bloques->contains($bloque)) {
            $this->bloques->removeElement($bloque);
            // set the owning side to null (unless already changed)
            if ($bloque->getBloquePadre() === $this) {
                $bloque->setBloquePadre(null);
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
        
        foreach ($this->getCampos() as $campo){
            if ($campo->getOrden() > $maxOrden){
                $maxOrden = $campo->getOrden();
            }
        }
        
        return $maxOrden + 1;
    }
    
    function getBloquePadre() {
        return $this->bloquePadre;
    }

    function setBloquePadre($bloquePadre) {
        $this->bloquePadre = $bloquePadre;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
