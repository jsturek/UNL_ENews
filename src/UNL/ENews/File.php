<?php
class UNL_ENews_File extends UNL_ENews_Record
{
    public $id;
    
    public $name;
    
    public $type;
    
    public $size;
    
    public $data;
    
    function getTable()
    {
        return 'files';
    }
}