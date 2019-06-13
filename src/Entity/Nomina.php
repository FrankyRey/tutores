<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nomina
 *
 * @ORM\Table(name="nomina")
 * @ORM\Entity
 */
class Nomina
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_nomina", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNomina;

    /**
     * @var string
     *
     * @ORM\Column(name="curp", type="string", length=18, nullable=false)
     */
    private $curp;

    /**
     * @var string
     *
     * @ORM\Column(name="plaza", type="string", length=26, nullable=false)
     */
    private $plaza;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_inicio", type="date", nullable=false)
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_fin", type="date", nullable=false)
     */
    private $fechaFin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codigo", type="string", length=3, nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="cct", type="string", length=10, nullable=false)
     */
    private $cct;

    public function getIdNomina(): ?int
    {
        return $this->idNomina;
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

    public function getPlaza(): ?string
    {
        return $this->plaza;
    }

    public function setPlaza(string $plaza): self
    {
        $this->plaza = $plaza;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
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


}
