<?php
/**
 * Created by PhpStorm.
 * User: metr
 * Date: 08.10.15
 */

namespace kernel\classes\customization;


class File {

    public $name;
    public $type;
    public $tmpName;
    public $error;
    public $size;

    public function __construct(array $fileInfo) {
        $this->name = $fileInfo['name'];
        $this->type = $fileInfo['type'];
        $this->tmpName = $fileInfo['tmpName'];
        $this->error = $fileInfo['error'];
        $this->size = $fileInfo['size'];
    }

} 