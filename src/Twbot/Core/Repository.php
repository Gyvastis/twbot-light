<?php

namespace Twbot\Core;


use Twbot\Exception\DatabaseException;

abstract class Repository
{
    /**
     * @var \medoo
     */
    protected $db;

    /**
     * TwitterFollowRepository constructor.
     */
    public function __construct()
    {
        $this->db = getProvider('db');
    }

    /**
     * @throws DatabaseException
     */
    protected function handleDatabaseException()
    {
        $error = $this->db->error();

        if (!isset($error[2]) && !empty($error[2])) {
            throw new DatabaseException($error[2]);
        }

        unset($error);
    }
}