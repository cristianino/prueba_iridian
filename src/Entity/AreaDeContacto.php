<?php

namespace App\Entity;

use App\Repository\AreaDeContactoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AreaDeContactoRepository::class)]
class AreaDeContacto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $nombre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public  function getNombre(): string
    {
        return $this->nombre;
    }

    public  function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function __toString()
    {
        return $this->nombre;
    }
}
