<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SolicitudCentro
 *
 * @ORM\Table(name="solicitud_centro", indexes={@ORM\Index(name="fk_solicitud_centro_solicitud_usuario1_idx", columns={"id_solicitud"}), @ORM\Index(name="fk_solicitud_centro_niveles_educativos1_idx", columns={"id_nivel"})})
 * @ORM\Entity
 */
class SolicitudCentro
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_solicitud_centro", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSolicitudCentro;

    /**
     * @var string
     *
     * @ORM\Column(name="cct", type="string", length=10, nullable=false)
     */
    private $cct;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inicio", type="date", nullable=false)
     */
    private $inicio;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_cct", type="string", length=200, nullable=false)
     */
    private $nombreCct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono_cct", type="string", length=20, nullable=true)
     */
    private $telefonoCct;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zona_escolar", type="string", length=3, nullable=true)
     */
    private $zonaEscolar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sector_escolar", type="string", length=3, nullable=true)
     */
    private $sectorEscolar;

    /**
     * @var string|null
     *
     * @ORM\Column(name="asignatura", type="string", length=100, nullable=true)
     */
    private $asignatura;

    /**
     * @var string|null
     *
     * @ORM\Column(name="taller", type="string", length=100, nullable=true)
     */
    private $taller;

    /**
     * @var string
     *
     * @ORM\Column(name="curp", type="string", length=18, nullable=false)
     */
    private $curp;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="acepta_terminos", type="boolean", nullable=true)
     */
    private $aceptaTerminos = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="fecha_acepta", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $fechaAcepta = 'CURRENT_TIMESTAMP';

    /**
     * @var \NivelesEducativos
     *
     * @ORM\ManyToOne(targetEntity="NivelesEducativos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_nivel", referencedColumnName="id_nivel_educativo")
     * })
     */
    private $idNivel;

    /**
     * @var \SolicitudUsuario
     *
     * @ORM\ManyToOne(targetEntity="SolicitudUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_solicitud", referencedColumnName="id_solicitud_usuario")
     * })
     */
    private $idSolicitud;

    public function getIdSolicitudCentro(): ?int
    {
        return $this->idSolicitudCentro;
    }

    public function getCct(): ?string
    {
        return $this->cct;
    }

    public function setCct(string $cct): self
    {
        $this->cct = $cct;

        return $this;
    }

    public function getInicio(): ?\DateTimeInterface
    {
        return $this->inicio;
    }

    public function setInicio(\DateTimeInterface $inicio): self
    {
        $this->inicio = $inicio;

        return $this;
    }

    public function getNombreCct(): ?string
    {
        return $this->nombreCct;
    }

    public function setNombreCct(string $nombreCct): self
    {
        $this->nombreCct = $nombreCct;

        return $this;
    }

    public function getTelefonoCct(): ?string
    {
        return $this->telefonoCct;
    }

    public function setTelefonoCct(?string $telefonoCct): self
    {
        $this->telefonoCct = $telefonoCct;

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

    public function getAsignatura(): ?string
    {
        return $this->asignatura;
    }

    public function setAsignatura(?string $asignatura): self
    {
        $this->asignatura = $asignatura;

        return $this;
    }

    public function getTaller(): ?string
    {
        return $this->taller;
    }

    public function setTaller(?string $taller): self
    {
        $this->taller = $taller;

        return $this;
    }

    public function getCurp(): ?string
    {
        return $this->curp;
    }

    public function setCurp(string $curp): self
    {
        $this->curp = $curp;

        return $this;
    }

    public function getAceptaTerminos(): ?bool
    {
        return $this->aceptaTerminos;
    }

    public function setAceptaTerminos(?bool $aceptaTerminos): self
    {
        $this->aceptaTerminos = $aceptaTerminos;

        return $this;
    }

    public function getFechaAcepta(): ?\DateTimeInterface
    {
        return $this->fechaAcepta;
    }

    public function setFechaAcepta(?\DateTimeInterface $fechaAcepta): self
    {
        $this->fechaAcepta = $fechaAcepta;

        return $this;
    }

    public function getIdNivel(): ?NivelesEducativos
    {
        return $this->idNivel;
    }

    public function setIdNivel(?NivelesEducativos $idNivel): self
    {
        $this->idNivel = $idNivel;

        return $this;
    }

    public function getIdSolicitud(): ?SolicitudUsuario
    {
        return $this->idSolicitud;
    }

    public function setIdSolicitud(?SolicitudUsuario $idSolicitud): self
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }


}
