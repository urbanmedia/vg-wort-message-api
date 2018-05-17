<?php

namespace VGWort\MessageService;

class okMessage
{

    /**
     * @var okType $status
     * @access public
     */
    public $status = null;

    /**
     * @param okType $status
     * @access public
     */
    public function __construct($status)
    {
      $this->status = $status;
    }

}