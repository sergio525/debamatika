<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipoInstaladoRepository")
 */
class EquipoInstalado
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Instalacion", inversedBy="equiposInstalados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $instalacion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idMaquina;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroRevision;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plantilla", mappedBy="equipo", orphanRemoval=true)
     */
    private $plantillas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Informe", mappedBy="equipo", orphanRemoval=true)
     */
    private $informes;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TipoEquipo", inversedBy="equipoInstalados")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoEquipo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;
    
    public function __construct()
    {
        $this->plantillas = new ArrayCollection();
        $this->informes = new ArrayCollection();
    }

    public function __toString() {
        return $this->descripcion;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInstalacion(): ?Instalacion
    {
        return $this->instalacion;
    }

    public function setInstalacion(?Instalacion $instalacion): self
    {
        $this->instalacion = $instalacion;

        return $this;
    }

   
    public function getIdMaquina(): ?string
    {
        return $this->idMaquina;
    }

    public function setIdMaquina(string $idMaquina): self
    {
        $this->idMaquina = $idMaquina;

        return $this;
    }

    public function getNumeroRevision(): ?string
    {
        return $this->numeroRevision;
    }

    public function setNumeroRevision(string $numeroRevision): self
    {
        $this->numeroRevision = $numeroRevision;

        return $this;
    }

    /**
     * @return Collection|Plantilla[]
     */
    public function getPlantillas(): Collection
    {
        return $this->plantillas;
    }

    public function addPlantilla(Plantilla $plantilla): self
    {
        if (!$this->plantillas->contains($plantilla)) {
            $this->plantillas[] = $plantilla;
            $plantilla->setEquipo($this);
        }

        return $this;
    }

    public function removePlantilla(Plantilla $plantilla): self
    {
        if ($this->plantillas->contains($plantilla)) {
            $this->plantillas->removeElement($plantilla);
            // set the owning side to null (unless already changed)
            if ($plantilla->getEquipo() === $this) {
                $plantilla->setEquipo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Informe[]
     */
    public function getInformes(): Collection
    {
        return $this->informes;
    }

    public function addInforme(Informe $informe): self
    {
        if (!$this->informes->contains($informe)) {
            $this->informes[] = $informe;
            $informe->setEquipo($this);
        }

        return $this;
    }

    public function removeInforme(Informe $informe): self
    {
        if ($this->informes->contains($informe)) {
            $this->informes->removeElement($informe);
            // set the owning side to null (unless already changed)
            if ($informe->getEquipo() === $this) {
                $informe->setEquipo(null);
            }
        }

        return $this;
    }

    public function getTipoEquipo(): ?TipoEquipo
    {
        return $this->tipoEquipo;
    }

    public function setTipoEquipo(?TipoEquipo $tipoEquipo): self
    {
        $this->tipoEquipo = $tipoEquipo;

        return $this;
    }
    
    function getDescripcion() {
        return $this->descripcion;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

}
