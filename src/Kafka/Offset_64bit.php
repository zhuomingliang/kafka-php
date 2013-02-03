<?php

/**
 * This class wraps the long format for message offset attributes
 * for 64bit php installations.
 *
 * @author michal.harish@gmail.com
 */

namespace Kafka;

class Offset implements IOffset
{
    /**
     * the actual integer value of the offset
     * @var int
     */
    private $int64;

    /**
     * Creates an instance of an Offset from binary data
     * @param string $data
     */
    public static function createFromData($data)
    {
        $offset = new Offset();
        $return = unpack('Va/Vb', $data);
        $offset->int64 = $return['a'] + ($return['b'] << 32);
        return $offset;
    }

    /**
     * Creating new offset can take initial hex value,
     * e.g new Offset("654654365465")
     *
     * @param string $fromString Decimal string
     */
    public function __construct($fromString = null)
    {              
        $this->int64 = intval($fromString);
    }

    /**
     * Print me
     */
    public function __toString()
    {
    	return (string) $this->int64;
    }

    /**
     * Return raw offset data.
     * @return string[8]
     */
    public function getData()
    {
    	$data = pack('V', $this->int64) . pack('V', $this->int64 >> 32);
        return $data;
    }

    /**
     * Increment offset by an integer
     * @param int $value
     */
    public function addInt($value)
    {
        $this->int64 += $value;
    }

    /**
     * Subtract integer from the offset
     * @param unknown_type $value
     */
    public function subInt($value)
    {
        $this->int64 -= $value;
    }

    /**
     * Add an offset interval
     * @param Offset $value
     */
    public function add(Offset $value)
    {
        $this->addint($value->int64);
    }

    /**
     * Subtract an offset interval
     * @param Offset $value
     */
    public function sub(Offset $value)
    {
        $this->subInt($value->int64);
    }

}