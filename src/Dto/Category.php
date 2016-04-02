<?php
namespace KeineWaste\Dto;

/**
 * @Entity
 * @Table(name="keinewaste.categories")
 **/
class Category extends Dto implements \JsonSerializable
{
    function __construct($id, $title = '')
    {
        // @todo: remove empty title, used in fixtures
        $this->id = $id;
        $this->title = $title;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }

    /**
     * @var int $id
     * @Id @Column(type="integer", name="id")
     */
    protected $id;

    /** @Column(type="string") */
    protected $title;
}