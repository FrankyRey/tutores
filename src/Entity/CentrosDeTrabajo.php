<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CentrosDeTrabajo
 *
 * @ORM\Table(name="centros_de_trabajo")
 * @ORM\Entity
 */
class CentrosDeTrabajo
{
    /**
     * @var string
     *
     * @ORM\Column(name="cct", type="string", length=10, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nombre_cct", type="string", length=100, nullable=true)
     */
    private $nombreCct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zona_escolar", type="string", length=10, nullable=true)
     */
    private $zonaEscolar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sector_escolar", type="string", length=10, nullable=true)
     */
    private $sectorEscolar;

    public function getCct(): ?string
    {
        return $this->cct;
    }

    public function getNombreCct(): ?string
    {
        return $this->nombreCct;
    }

    public function setNombreCct(?string $nombreCct): self
    {
        $this->nombreCct = $nombreCct;

        return $this;
    }

    public function getZonaEscolar(): ?string
    {
        return $this->zonaEscolar;
    }

    public function setZonaEscolar(?string $zonaEscolar): self
    {
        $this->zonaEscolar = $zonaEscolar;

        return $this;
    }

    public function getSectorEscolar(): ?string
    {
        return $this->sectorEscolar;
    }

    public function setSectorEscolar(?string $sectorEscolar): self
    {
        $this->sectorEscolar = $sectorEscolar;

        return $this;
    }


}
