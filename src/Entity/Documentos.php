<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Documentos
 *
 * @ORM\Table(name="documentos", indexes={@ORM\Index(name="fk_documentos_fos_user1_idx", columns={"id_user"})})
 * @ORM\Entity
 */
class Documentos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_documentos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDocumentos;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre_documento", type="string", length=45, nullable=false)
     */
    private $nombreDocumento;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia", type="string", length=45, nullable=false)
     */
    private $referencia;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdDocumentos(): ?int
    {
        return $this->idDocumentos;
    }

    public function getNombreDocumento(): ?string
    {
        return $this->nombreDocumento;
    }

    public function setNombreDocumento(string $nombreDocumento): self
    {
        $this->nombreDocumento = $nombreDocumento;

        return $this;
    }

    public function getReferencia(): ?string
    {
        return $this->referencia;
    }

    public function setReferencia(string $referencia): self
    {
        $this->referencia = $referencia;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
