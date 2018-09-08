<?php


namespace xenialdan\astar3d;

class SurfaceType implements \Serializable
{
    /** @var int */
    public $layerMask;
    /** @var int */
    public $penalty;

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->layerMask,
            $this->penalty
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list(
            $this->layerMask,
            $this->penalty
            ) = unserialize($serialized);
    }
}