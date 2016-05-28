<?php
namespace SFramework\Classes\Customization;


/**
 * Class File
 * @package SFramework\Classes\Customization
 */
class File
{

    public $name;
    public $type;
    public $tmpName;
    public $error;
    public $size;

    public function __construct(array $fileInfo)
    {
        $this->name = $fileInfo['name'];
        $this->type = $fileInfo['type'];
        $this->tmpName = $fileInfo['tmpName'];
        $this->error = $fileInfo['error'];
        $this->size = $fileInfo['size'];
    }

} 