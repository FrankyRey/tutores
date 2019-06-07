<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NivelConvocatoria
 *
 * @ORM\Table(name="nivel_convocatoria", uniqueConstraints={@ORM\UniqueConstraint(name="CURP_NIVEL", columns={"curp", "nivel_convocatoria"})})
 * @ORM\Entity
 */
class NivelConvocatoria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_nivel_convocatoria", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNivelConvocatoria;

    /**
     * @var string
     *
     * @ORM\Column(name="curp", type="string", length=18, nullable=false)
     */
    private $curp;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel_convocatoria", type="string", length=15, nullable=false)
     */
    private $nivelConvocatoria;

    public function getIdNivelConvocatoria(): ?int
    {
        return $this->idNivelConvocatoria;
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

    public function getNivelConvocatoria(): ?string
    {
        return $this->nivelConvocatoria;
    }

    public function setNivelConvocatoria(string $nivelConvocatoria): self
    {
        $this->nivelConvocatoria = $nivelConvocatoria;

        return $this;
    }


}
