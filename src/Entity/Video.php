<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="text", length=100)
     */
    private $title;

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    public function getDescription() {
        return $this->description;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * @ORM\Column(type="text")
     */
    private $filename;

    public function getFilename(){
        return $this->filename;
    }
    
    public function setFilename($filename){
        $this->filename = $filename; 
    }

}
