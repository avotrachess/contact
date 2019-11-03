<?php

namespace App\Models;

use App\Database;
use App\Models\AbstractModel;

class UserModel extends AbstractModel
{
    /** @var string  */
    protected $table = "users";

    /**
     * UserModel constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        parent::__construct($database);

        // $this->model = new AbstractModel();
    }

    /**
     * @return mixed
     */
    public function login()
    {
        //@TODO
    }
}