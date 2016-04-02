<?php

namespace KeineWaste\Dto;

/**
 * @Entity
 * @Table(name="keinewaste.TestEntity")
 **/
class TestEntity extends Dto implements \JsonSerializable
{

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
        ];
    }


    /**
     * @Id @Column(type="integer", name="id") @GeneratedValue
     * @var int $id
     */
    protected $id;
}