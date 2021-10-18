<?php

namespace App\Entity;

use App\Entity\Admin\tipoCampo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CampoRepository")
 */
class Campo
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $ayuda;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unidad;

    /**
     * @ORM\Column(type="integer")
     */
    private $orden;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Bloque", inversedBy="campos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloque;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Variable", mappedBy="campo", orphanRemoval=true)
     */
    private $variables;

    /**
     * @ORM\Column(type="boolean")
     */
    private $multiple;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Anotacion", mappedBy="campo", orphanRemoval=true)
     */
    private $anotaciones;

    public function __construct()
    {
        $this->variables = new ArrayCollection();
        $this->anotaciones = new ArrayCollection();
    }
    
    public function __toString() {
        return $this->titulo;;
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

    public function getAyuda(): ?string
    {
        return $this->ayuda;
    }

    public function setAyuda(?string $ayuda): self
    {
        $this->ayuda = $ayuda;

        return $this;
    }

    public function getUnidad(): ?string
    {
        return $this->unidad;
    }

    public function setUnidad(?string $unidad): self
    {
        $this->unidad = $unidad;

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

    public function getBloque(): ?Bloque
    {
        return $this->bloque;
    }

    public function setBloque(?Bloque $bloque): self
    {
        $this->bloque = $bloque;

        return $this;
    }
    
    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * @return Collection|Variable[]
     */
    public function getVariables(): Collection
    {
        return $this->variables;
    }

    public function addVariable(Variable $variable): self
    {
        if (!$this->variables->contains($variable)) {
            $this->variables[] = $variable;
            $variable->setCampo($this);
        }

        return $this;
    }

    public function removeVariable(Variable $variable): self
    {
        if ($this->variables->contains($variable)) {
            $this->variables->removeElement($variable);
            // set the owning side to null (unless already changed)
            if ($variable->getCampo() === $this) {
                $variable->setCampo(null);
            }
        }

        return $this;
    }
    
     public function getOrdenNuevo(){
        $elementos = count($this->getVariables()) + 1;
        return $elementos;
    }

     public function getMultiple(): ?bool
     {
         return $this->multiple;
     }

     public function setMultiple(bool $multiple): self
     {
         $this->multiple = $multiple;

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
             $anotacione->setCampo($this);
         }

         return $this;
     }

     public function removeAnotacione(Anotacion $anotacione): self
     {
         if ($this->anotaciones->contains($anotacione)) {
             $this->anotaciones->removeElement($anotacione);
             // set the owning side to null (unless already changed)
             if ($anotacione->getCampo() === $this) {
                 $anotacione->setCampo(null);
             }
         }

         return $this;
     }
}
