<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=EmpleadoRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class Empleado implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primerApellido;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $segundoApellido;

    /**
     * @ORM\Column(type="boolean")
     */
    private $fichado;

    /**
     * @ORM\ManyToOne(targetEntity=Horario::class, inversedBy="empleados")
     */
    private $horario;

    /**
     * @ORM\OneToMany(targetEntity=Incidencia::class, mappedBy="empleado")
     */
    private $incidencia;

    /**
     * @ORM\OneToMany(targetEntity=Comentario::class, mappedBy="empleado")
     */
    private $comentario;

    /**
     * @ORM\ManyToOne(targetEntity=Calendario::class, inversedBy="empleados")
     */
    private $calendario;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    public function __construct()
    {
        $this->incidencia = new ArrayCollection();
        $this->comentario = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primerApellido;
    }

    public function setPrimerApellido(string $primerApellido): self
    {
        $this->primerApellido = $primerApellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundoApellido;
    }

    public function setSegundoApellido(string $segundoApellido): self
    {
        $this->segundoApellido = $segundoApellido;

        return $this;
    }

    public function getFichado(): ?bool
    {
        return $this->fichado;
    }

    public function setFichado(bool $fichado): self
    {
        $this->fichado = $fichado;

        return $this;
    }

    public function getHorario(): ?Horario
    {
        return $this->horario;
    }

    public function setHorario(?Horario $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * @return Collection|Incidencia[]
     */
    public function getIncidencia(): Collection
    {
        return $this->incidencia;
    }

    public function addIncidencium(Incidencia $incidencium): self
    {
        if (!$this->incidencia->contains($incidencium)) {
            $this->incidencia[] = $incidencium;
            $incidencium->setEmpleado($this);
        }

        return $this;
    }

    public function removeIncidencium(Incidencia $incidencium): self
    {
        if ($this->incidencia->removeElement($incidencium)) {
            // set the owning side to null (unless already changed)
            if ($incidencium->getEmpleado() === $this) {
                $incidencium->setEmpleado(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comentario[]
     */
    public function getComentario(): Collection
    {
        return $this->comentario;
    }

    public function addComentario(Comentario $comentario): self
    {
        if (!$this->comentario->contains($comentario)) {
            $this->comentario[] = $comentario;
            $comentario->setEmpleado($this);
        }

        return $this;
    }

    public function removeComentario(Comentario $comentario): self
    {
        if ($this->comentario->removeElement($comentario)) {
            // set the owning side to null (unless already changed)
            if ($comentario->getEmpleado() === $this) {
                $comentario->setEmpleado(null);
            }
        }

        return $this;
    }

    public function getCalendario(): ?Calendario
    {
        return $this->calendario;
    }

    public function setCalendario(?Calendario $calendario): self
    {
        $this->calendario = $calendario;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
