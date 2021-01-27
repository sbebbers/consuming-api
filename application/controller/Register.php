<?php
namespace ShaunB\Appplcation\Controller;

use ShaunB\Applcation\Core\ConsumingAPIException;

class Register extends RequestHandler
{

    /**
     * <p>Client ID</p>
     *
     * @var string $clientId
     */
    protected $clientId;

    /**
     * <p>Email address</p>
     *
     * @var string $email
     */
    protected $email;

    /**
     * <p>User's given or chosen name</p>
     *
     * @var string $name
     */
    protected $name;

    /**
     * <p>Set client ID for the post request</p>
     *
     * @param string $clientId
     * @return Register
     */
    public function setClientId(string $clientId): Register
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * <p>Set the user email address for the post request</p>
     *
     * @param string $email
     * @return Register
     */
    public function setEmail(string $email): Register
    {
        $this->email = $email;

        return $this;
    }

    /**
     * <p>Set the user's name for the post request</p>
     *
     * @param string $name
     * @return Register
     */
    public function setName(string $name): Register
    {
        $this->name = $name;

        return $this;
    }

    /**
     * <p>Returns the Client ID</p>
     *
     * @throws ConsumingAPIException
     * @return string
     */
    public function getClientId(): ?string
    {
        if (empty($this->clientId)) {
            throw new ConsumingAPIException('Client ID not set', ConsumingAPIException::MISSING_PARAMETER);
        }

        return $this->clientId;
    }

    /**
     * <p>Returns cliend Email address</p>
     *
     * @throws ConsumingAPIException
     * @return string|NULL
     */
    public function getEmail(): ?string
    {
        if (empty($this->email)) {
            throw new ConsumingAPIException('Email address is not set', ConsumingAPIException::MISSING_PARAMETER);
        }

        return $this->email;
    }

    /**
     * <p>Returns client name</p>
     *
     * @throws ConsumingAPIException
     * @return string|NULL
     */
    public function getName(): ?string
    {
        if (empty($this->name)) {
            throw new ConsumingAPIException('Name is not set', ConsumingAPIException::MISSING_PARAMETER);
        }

        return $this->name;
    }
}
