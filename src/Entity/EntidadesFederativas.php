<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EntidadesFederativas
 *
 * @ORM\Table(name="entidades_federativas")
 * @ORM\Entity
 */
class EntidadesFederativas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_entidad_federativa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEntidadFederativa;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_entidad_federativa", type="string", length=50, nullable=false)
     */
    private $nombreEntidadFederativa;

    public function getIdEntidadFederativa(): ?int
    {
        return $this->idEntidadFederativa;
    }

    public function getNombreEntidadFederativa(): ?string
    {
        return $this->nombreEntidadFederativa;
    }

    public function setNombreEntidadFederativa(string $nombreEntidadFederativa): self
    {
        $this->nombreEntidadFederativa = $nombreEntidadFederativa;

        return $this;
    }


}
