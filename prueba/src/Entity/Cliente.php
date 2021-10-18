<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClienteRepository")
 */
class Cliente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(
     *      message = "Este campo es obligatorio."
     * )
     * 
     */
    private $razonSocial;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Este campo es obligatorio."
     * )
     * @Assert\Email(
     *     message = "'{{ value }}' no es un email valido."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telefono;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cif;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Este campo es obligatorio."
     * )
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localidad;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Instalacion", mappedBy="cliente", orphanRemoval=true)
     */
    private $instalaciones;

    public function __construct()
    {
        $this->equipos = new ArrayCollection();
        $this->instalaciones = new ArrayCollection();
    }
    
    public function __toString(){
        return $this->razonSocial;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRazonSocial(): ?string
    {
        return $this->razonSocial;
    }

    public function setRazonSocial(string $razonSocial): self
    {
        $this->razonSocial = $razonSocial;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getCif(): ?string
    {
        return $this->cif;
    }

    public function setCif(string $cif): self
    {
        $this->cif = $cif;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

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
            $equipo->addCliente($this);
        }

        return $this;
    }

    public function removeEquipo(Equipo $equipo): self
    {
        if ($this->equipos->contains($equipo)) {
            $this->equipos->removeElement($equipo);
            $equipo->removeCliente($this);
        }

        return $this;
    }

    /**
     * @return Collection|Instalacion[]
     */
    public function getInstalaciones(): Collection
    {
        return $this->instalaciones;
    }

    public function addInstalacione(Instalacion $instalacione): self
    {
        if (!$this->instalaciones->contains($instalacione)) {
            $this->instalaciones[] = $instalacione;
            $instalacione->setCliente($this);
        }

        return $this;
    }

    public function removeInstalacione(Instalacion $instalacione): self
    {
        if ($this->instalaciones->contains($instalacione)) {
            $this->instalaciones->removeElement($instalacione);
            // set the owning side to null (unless already changed)
            if ($instalacione->getCliente() === $this) {
                $instalacione->setCliente(null);
            }
        }

        return $this;
    }
}
