<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Municipios
 *
 * @ORM\Table(name="municipios", indexes={@ORM\Index(name="fk_municipios_entidades_federativas", columns={"id_entidad_federativa"})})
 * @ORM\Entity
 */
class Municipios
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_municipios", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idMunicipios;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_municipios", type="string", length=150, nullable=false)
     */
    private $nombreMunicipios;

    /**
     * @var \EntidadesFederativas
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="EntidadesFederativas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_entidad_federativa", referencedColumnName="id_entidad_federativa")
     * })
     */
    private $idEntidadFederativa;

    public function getIdMunicipios(): ?int
    {
        return $this->idMunicipios;
    }

    public function getNombreMunicipios(): ?string
    {
        return $this->nombreMunicipios;
    }

    public function setNombreMunicipios(string $nombreMunicipios): self
    {
        $this->nombreMunicipios = $nombreMunicipios;

        return $this;
    }

    public function getIdEntidadFederativa(): ?EntidadesFederativas
    {
        return $this->idEntidadFederativa;
    }

    public function setIdEntidadFederativa(?EntidadesFederativas $idEntidadFederativa): self
    {
        $this->idEntidadFederativa = $idEntidadFederativa;

        return $this;
    }

    public function __toString()
    {
        return $this->nombreMunicipios;
    }

}
