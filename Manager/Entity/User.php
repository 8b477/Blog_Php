<?php

namespace App\Manager\Entity;

class User extends AbstractEntity
{
        private string $username;
        private string $mail;
        private string $password;
        private string $confirmation_token;
        private \DateTime $confirmed_at;
        private string $reset_token;
        private \DateTime $reset_at;


    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail(string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConfirmationToken(): string
    {
        return $this->confirmation_token;
    }

    /**
     * @param string $confirmation_token
     */
    public function setConfirmationToken(string $confirmation_token): void
    {
        $this->confirmation_token = $confirmation_token;
    }

    /**
     * @return \DateTime
     */
    public function getConfirmedAt(): \DateTime
    {
        return $this->confirmed_at;
    }

    /**
     * @param \DateTime $confirmed_at
     */
    public function setConfirmedAt(\DateTime $confirmed_at): void
    {
        $this->confirmed_at = $confirmed_at;
    }

    /**
     * @return string
     */
    public function getResetToken(): string
    {
        return $this->reset_token;
    }

    /**
     * @param string $reset_token
     */
    public function setResetToken(string $reset_token): void
    {
        $this->reset_token = $reset_token;
    }

    /**
     * @return \DateTime
     */
    public function getResetAt(): \DateTime
    {
        return $this->reset_at;
    }

    /**
     * @param \DateTime $reset_at
     */
    public function setResetAt(\DateTime $reset_at): void
    {
        $this->reset_at = $reset_at;
    }

}