<?php

namespace Application\Model;

use RuntimeException;
use Core\Model;
use Zend\Session\SessionManager;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Storage\StorageInterface;


class SalerTable extends Model\ModelTable
{
    private $_storage;
    private $_resolvedIdentity;

    const COOKIE_NAME = 'auth';

    public function authenticate($login, $password)
    {
        $rowSet = $this->_tableGateway->select(['email' => $login, 'password' => md5($password)]);
        $row = $rowSet->current();
        if (!$row) {
            return false;
        }
        $data = [
            'key'   => $this->_hasheCookie($row->getEmail(), $row->getPassword()),
            'name'  => $row->getName(),
            'store' => $row->getStoreId(),
            'id'    => $row->getId()
        ];
        $this->_write($data);
        return true;
    }

    public function logout()
    {
        $this->getStorage()->clear();
    }

    public function checkAuthorization()
    {
        $rows = $this->fetchAll();
        foreach ($rows as $user) {
            if ($this->_hasheCookie($user->getEmail(), $user->getPassword()) == $this->_read()) {
                return true;
            }
        }
        return null;
    }

    private function _hasheCookie($login, $password)
    {
        return md5($login . md5($password));
    }

    /**
     * @return StorageInterface
     */
    public function getStorage()
    {
        if ($this->_storage === null) {
            $this->setStorage(new Session(self::COOKIE_NAME));
        }
        return $this->_storage;
    }

    /**
     * @param StorageInterface $storage
     *
     * @return AuthStorage $this
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->_storage = $storage;
        return $this;
    }

    private function _write($data)
    {
        $this->getStorage()->write($data);
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If reading contents from storage is impossible
     * @return mixed
     */
    public function _read()
    {
        if ($this->_resolvedIdentity !== null) {
            return $this->_resolvedIdentity;
        }
        $data = $this->getStorage()->read();
        if ($data['key']) {
            $this->_resolvedIdentity = $data['key'];
        } else {
            $this->_resolvedIdentity = null;
        }
        return $this->_resolvedIdentity;
    }

    public function getName()
    {
        $data = $this->getStorage()->read();
        return $data['name'];
    }

    public function getStoreId()
    {
        $data = $this->getStorage()->read();
        return $data['store'];
    }

    public function getId()
    {
        $data = $this->getStorage()->read();
        return $data['id'];
    }
}
