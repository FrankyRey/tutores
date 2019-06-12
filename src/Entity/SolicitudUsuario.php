<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SolicitudUsuario
 *
 * @ORM\Table(name="solicitud_usuario", indexes={@ORM\Index(name="fk_solicitud_usuario_fos_user1_idx", columns={"id_user"}), @ORM\Index(name="fk_solicitud_usuario_municipios", columns={"id_municipio_entidad_federativa", "id_municipio"}), @ORM\Index(name="fk_solicitud_usuario_entidad_federativa", columns={"id_entidad_federativa"})})
 * @ORM\Entity
 */
class SolicitudUsuario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_solicitud_usuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSolicitudUsuario;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido_paterno", type="string", length=50, nullable=false)
     */
    private $apellidoPaterno;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellido_materno", type="string", length=50, nullable=true)
     */
    private $apellidoMaterno;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=70, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="rfc", type="string", length=13, nullable=false)
     */
    private $rfc;

    /**
     * @var string
     *
     * @ORM\Column(name="curp", type="string", length=18, nullable=false)
     */
    private $curp;

    /**
     * @var int|null
     *
     * @ORM\Column(name="edad", type="integer", nullable=true)
     */
    private $edad;

    /**
     * @var string
     *
     * @ORM\Column(name="calle", type="string", length=150, nullable=false)
     */
    private $calle;

    /**
     * @var string
     *
     * @ORM\Column(name="no_exterior", type="string", length=20, nullable=false)
     */
    private $noExterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="no_interior", type="string", length=20, nullable=true)
     */
    private $noInterior;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono_fijo", type="string", length=15, nullable=true)
     */
    private $telefonoFijo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono_celular", type="string", length=15, nullable=true)
     */
    private $telefonoCelular;

    /**
     * @var string
     *
     * @ORM\Column(name="nivel_convocatoria", type="string", length=15, nullable=false)
     */
    private $nivelConvocatoria;

    /**
     * @var string|null
     *
     * @ORM\Column(name="codigo_postal", type="string", length=5, nullable=true)
     */
    private $codigoPostal;

    /**
     * @var string|null
     *
     * @ORM\Column(name="colonia", type="string", length=200, nullable=true)
     */
    private $colonia;

    /**
     * @var \EntidadesFederativas
     *
     * @ORM\ManyToOne(targetEntity="EntidadesFederativas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_entidad_federativa", referencedColumnName="id_entidad_federativa")
     * })
     */
    private $idEntidadFederativa;

    /**
     * @var \Municipios
     *
     * @ORM\ManyToOne(targetEntity="Municipios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_municipio_entidad_federativa", referencedColumnName="id_entidad_federativa"),
     *   @ORM\JoinColumn(name="id_municipio", referencedColumnName="id_municipios")
     * })
     */
    private $idMunicipioEntidadFederativa;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdSolicitudUsuario(): ?int
    {
        return $this->idSolicitudUsuario;
    }

    public function getApellidoPaterno(): ?string
    {
        return $this->apellidoPaterno;
    }

    public function setApellidoPaterno(string $apellidoPaterno): self
    {
        $this->apellidoPaterno = $apellidoPaterno;

        return $this;
    }

    public function getApellidoMaterno(): ?string
    {
        return $this->apellidoMaterno;
    }

    public function setApellidoMaterno(?string $apellidoMaterno): self
    {
        $this->apellidoMaterno = $apellidoMaterno;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getRfc(): ?string
    {
        return $this->rfc;
    }

    public function setRfc(string $rfc): self
    {
        $this->rfc = $rfc;

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

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(?int $edad): self
    {
        $this->edad = $edad;

        return $this;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): self
    {
        $this->calle = $calle;

        return $this;
    }

    public function getNoExterior(): ?string
    {
        return $this->noExterior;
    }

    public function setNoExterior(string $noExterior): self
    {
        $this->noExterior = $noExterior;

        return $this;
    }

    public function getNoInterior(): ?string
    {
        return $this->noInterior;
    }

    public function setNoInterior(?string $noInterior): self
    {
        $this->noInterior = $noInterior;

        return $this;
    }

    public function getTelefonoFijo(): ?string
    {
        return $this->telefonoFijo;
    }

    public function setTelefonoFijo(?string $telefonoFijo): self
    {
        $this->telefonoFijo = $telefonoFijo;

        return $this;
    }

    public function getTelefonoCelular(): ?string
    {
        return $this->telefonoCelular;
    }

    public function setTelefonoCelular(?string $telefonoCelular): self
    {
        $this->telefonoCelular = $telefonoCelular;

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

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(?string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getColonia(): ?string
    {
        return $this->colonia;
    }

    public function setColonia(?string $colonia): self
    {
        $this->colonia = $colonia;

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

    public function getIdMunicipioEntidadFederativa(): ?Municipios
    {
        return $this->idMunicipioEntidadFederativa;
    }

    public function setIdMunicipioEntidadFederativa(?Municipios $idMunicipioEntidadFederativa): self
    {
        $this->idMunicipioEntidadFederativa = $idMunicipioEntidadFederativa;

        return $this;
    }

    public function getIdUser(): ?FosUser
    {
        return $this->idUser;
    }

    public function setIdUser(?FosUser $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
