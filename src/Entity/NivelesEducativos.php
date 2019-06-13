<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NivelesEducativos
 *
 * @ORM\Table(name="niveles_educativos")
 * @ORM\Entity
 */
class NivelesEducativos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_nivel_educativo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNivelEducativo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_nivel", type="string", length=45, nullable=true)
     */
    private $nombreNivel;

    public function getIdNivelEducativo(): ?int
    {
        return $this->idNivelEducativo;
    }

    public function getNombreNivel(): ?string
    {
        return $this->nombreNivel;
    }

    public function setNombreNivel(?string $nombreNivel): self
    {
        $this->nombreNivel = $nombreNivel;

        return $this;
    }


}
