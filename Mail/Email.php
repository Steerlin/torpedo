<?php

namespace Torpedo\Mail;

interface Email
{
    /**
     * @return array
     */
    public function getParams();

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @return string
     */
    public function getSubject();
}