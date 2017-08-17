<?php

namespace ModelBundle\Entity;

/**
 * Localidades
 */
class Localidades
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $cd;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \ModelBundle\Entity\Provincias
     */
    private $provincia;


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
     * Set cd
     *
     * @param integer $cd
     *
     * @return Localidades
     */
    public function setCd($cd)
    {
        $this->cd = $cd;

        return $this;
    }

    /**
     * Get cd
     *
     * @return integer
     */
    public function getCd()
    {
        return $this->cd;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Localidades
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set provincia
     *
     * @param \ModelBundle\Entity\Provincias $provincia
     *
     * @return Localidades
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
}

