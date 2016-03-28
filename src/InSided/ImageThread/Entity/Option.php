<?php

namespace InSided\ImageThread\Entity;

/**
 * @Entity @Table(name="options")
 */
class Option
{
    /**
     * @var integer
     *
     * @Column(name="option_id", type="integer")
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="key", type="string", length=255, nullable=false)
     */
    private $key;

    /**
     * @var string
     *
     * @Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;
    
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
     * Set key
     * 
     * @param string $key Option key
     * @return \InSided\ImageThread\Entity\Options Option
     */
    public function setKey($key) 
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey() 
    {
        return $this->key;
    }
    
    /**
     * Set value
     * 
     * @param string $value Option value
     * @return \InSided\ImageThread\Entity\Options Option
     */
    public function setValue($value) 
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
