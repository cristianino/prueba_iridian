<?php

namespace App\Entity;

use App\Repository\ContactoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactoRepository::class)]
class Contacto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /** @ORM\Column(type="string") */
    private $nombre;

    /** @ORM\Column(type="string") */
    private $apellido;

    /** @ORM\Column(type="string") */
    private $correo;

    /** @ORM\Column(type="string") */
    private $celular;

    /** @ORM\Column(type="datetime") */
    private $fechaEnvio;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AreaDeContacto")
     * @ORM\JoinColumn(nullable=false)
     */
    private $areaDeContacto;

    /** @ORM\Column(type="text") */
    private $mensaje;

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): self
    {
        $this->apellido = $apellido;
        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): self
    {
        $this->correo = $correo;
        return $this;
    }

    public function getCelular(): ?string
    {
        return $this->celular;
    }

    public function setCelular(string $celular): self
    {
        $this->celular = $celular;
        return $this;
    }

    public function getAreaDeContacto(): ?AreaDeContacto
    {
        return $this->areaDeContacto;
    }

    public function setAreaDeContacto(?AreaDeContacto $areaDeContacto): self
    {
        $this->areaDeContacto = $areaDeContacto;
        return $this;
    }

    public function getFechaEnvio(): ?\DateTimeInterface
    {
        return $this->fechaEnvio;
    }

    public function setFechaEnvio(\DateTimeInterface $fechaEnvio): self
    {
        $this->fechaEnvio = $fechaEnvio;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
