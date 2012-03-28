<?php

namespace Xi\Filelib\File;

use DateTime;

/**
 * Default file implementation
 *
 * @author pekkis
 *
 */
class FileItem implements File
{
    /**
     * Key to method mapping for fromArray
     * 
     * @var array
     */
    protected static $map = array(
        'id' => 'setId',
        'folder_id' => 'setFolderId',
        'mimetype' => 'setMimeType',
        'profile' => 'setProfile',
        'size' => 'setSize',
        'name' => 'setName',
        'link' => 'setLink',
        'date_uploaded' => 'setDateUploaded',
        'status' => 'setStatus',
    );
        
    /**
     * @var FileLibrary Filelib
     */
    private $filelib;
    
    private $id;
    
    private $folderId;
    
    private $mimetype;
    
    private $profile;
    
    private $size;
    
    private $name;
    
    private $link;
    
    private $dateUploaded;
    
    private $status;
    
    
    /**
     * @param type $id
     * @return FileItem 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setFolderId($folderId)
    {
        $this->folderId = $folderId;
        return $this;
    }
    
    public function getFolderId()
    {
        return $this->folderId;
    }

    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
        return $this;
    }
    
    public function getMimetype()
    {
        return $this->mimetype;
    }
    
    public function setProfile($profile)
    {
        $this->profile = $profile;
        return $this;
    }
    
    public function getProfile()
    {
        return $this->profile;
    }
    
    public function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
    
    public function getSize()
    {
        return $this->size;
    }
    
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }
    
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * Returns upload date
     * 
     * @return DateTime
     */
    public function getDateUploaded()
    {
        return $this->dateUploaded;
    }
    
    /**
     * Sets upload date
     * 
     * @param DateTime $dateUploaded
     * @return FileItem 
     */
    public function setDateUploaded(DateTime $dateUploaded)
    {
        $this->dateUploaded = $dateUploaded;
        return $this;
    }
    
    /**
     * Sets status
     * 
     * @param type integer
     * @return FileItem
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    
    /**
     * Returns status
     * 
     * @return integer
     */
    public function getStatus()
    {
       return $this->status; 
    }
    
    
    
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'folder_id' => $this->getFolderId(),
            'mimetype' => $this->getMimetype(),
            'profile' => $this->getProfile(),
            'size' => $this->getSize(),
            'name' => $this->getName(),
            'link' => $this->getLink(),
            'date_uploaded' => $this->getDateUploaded(),
            'status' => $this->getStatus(),
        );
    }
    
    public function fromArray(array $data)
    {
        foreach(static::$map as $key => $method) {
            if(isset($data[$key])) {
                $this->$method($data[$key]);
            }
        }
        return $this;
    }

    
    /**
     *
     * @param array $data
     * @return type FileItem
     */
    public static function create(array $data)
    {
        $file = new self();
        return $file->fromArray($data);
    } 

}
