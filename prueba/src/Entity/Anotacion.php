<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnotacionRepository")
 */
class Anotacion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Informe", inversedBy="anotaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $informe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Campo", inversedBy="anotaciones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $campo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observaciones;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $imagen;

    

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

    public function getCampo(): ?Campo
    {
        return $this->campo;
    }

    public function setCampo(?Campo $campo): self
    {
        $this->campo = $campo;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen( $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

   
}
