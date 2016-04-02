<?php



namespace KeineWaste\Config;


class General
{
    /**
     * Configuration entries
     *
     * @var array
     */
    protected $data = array();

    /**
     * Construct
     *
     * @param array $data Configuration entries
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get configuration entry value by key
     *
     * @param string $key Entry key
     *
     * @return mixed
     */
    public function get($key)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * Represent as array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }
}