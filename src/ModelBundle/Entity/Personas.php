<?php

namespace ModelBundle\Entity;

/**
 * Personas
 */
class Personas
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nif;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellido1;

    /**
     * @var string
     */
    private $apellido2;

    /**
     * @var \DateTime
     */
    private $fcnac;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $domicilio;

    /**
     * @var string
     */
    private $cdpostal;

    /**
     * @var string
     */
    private $movil;

    /**
     * @var string
     */
    private $telefono;

    /**
     * @var \ModelBundle\Entity\Provincias
     */
    private $provincia;

    /**
     * @var \ModelBundle\Entity\Localidades
     */
    private $localidad;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nif
     *
     * @param string $nif
     *
     * @return Personas
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Personas
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido1
     *
     * @param string $apellido1
     *
     * @return Personas
     */
    public function setApellido1($apellido1)
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    /**
     * Get apellido1
     *
     * @return string
     */
    public function getApellido1()
    {
        return $this->apellido1;
    }

    /**
     * Set apellido2
     *
     * @param string $apellido2
     *
     * @return Personas
     */
    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    /**
     * Get apellido2
     *
     * @return string
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * Set fcnac
     *
     * @param \DateTime $fcnac
     *
     * @return Personas
     */
    public function setFcnac($fcnac)
    {
        $this->fcnac = $fcnac;

        return $this;
    }

    /**
     * Get fcnac
     *
     * @return \DateTime
     */
    public function getFcnac()
    {
        return $this->fcnac;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Personas
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set domicilio
     *
     * @param string $domicilio
     *
     * @return Personas
     */
    public function setDomicilio($domicilio)
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    /**
     * Get domicilio
     *
     * @return string
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * Set cdpostal
     *
     * @param string $cdpostal
     *
     * @return Personas
     */
    public function setCdpostal($cdpostal)
    {
        $this->cdpostal = $cdpostal;

        return $this;
    }

    /**
     * Get cdpostal
     *
     * @return string
     */
    public function getCdpostal()
    {
        return $this->cdpostal;
    }

    /**
     * Set movil
     *
     * @param string $movil
     *
     * @return Personas
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return string
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Personas
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set provincia
     *
     * @param \ModelBundle\Entity\Provincias $provincia
     *
     * @return Personas
     */
    public function setProvincia(\ModelBundle\Entity\Provincias $provincia = null)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return \ModelBundle\Entity\Provincias
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set localidad
     *
     * @param \ModelBundle\Entity\Localidades $localidad
     *
     * @return Personas
     */
    public function setLocalidad(\ModelBundle\Entity\Localidades $localidad = null)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return \ModelBundle\Entity\Localidades
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }
}

