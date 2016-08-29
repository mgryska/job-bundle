<?php
/*
* This file is part of the job-bundle package.
*
* (c) Hannes Schulz <hannes.schulz@aboutcoders.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Abc\Bundle\JobBundle\Adapter\Sonata;

use Abc\ProcessControl\ControllerInterface;
use Sonata\NotificationBundle\Model\MessageInterface;
use Sonata\NotificationBundle\Model\MessageManagerInterface;

/**
 * A message manager controlled by a process controller that decorates the message manager injected in the constructor.
 *
 * @author Hannes Schulz <hannes.schulz@aboutcoders.com>
 */
class ControlledMessageManager implements MessageManagerInterface
{
    /**
     * @var ControllerInterface
     */
    protected $controller;

    /**
     * @var MessageManagerInterface
     */
    protected $manager;

    /**
     * @param ControllerInterface     $controller The controller
     * @param MessageManagerInterface $manager The message manage to be controlled
     */
    public function __construct(ControllerInterface $controller, MessageManagerInterface $manager)
    {
        $this->controller = $controller;
        $this->manager    = $manager;
    }

    /**
     * {@inheritDoc}
     */
    public function findByTypes(array $types, $state, $batchSize)
    {
        if ($this->controller != null && $this->controller->doExit()) {
            throw new IterationStoppedException();
        }

        return $this->manager->findByTypes($types, $state, $batchSize);
    }

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return $this->manager->getClass();
    }

    /**
     * {@inheritDoc}
     */
    public function findAll()
    {
        return $this->manager->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->manager->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * {@inheritDoc}
     */
    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return $this->manager->findOneBy($criteria, $orderBy);
    }

    /**
     * {@inheritDoc}
     */
    public function find($id)
    {
        return $this->manager->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {
        return $this->manager->create();
    }

    /**
     * {@inheritDoc}
     */
    public function save($entity, $andFlush = true)
    {
        return $this->manager->save($entity, $andFlush);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($entity, $andFlush = true)
    {
        return $this->manager->delete($entity, $andFlush);
    }

    /**
     * {@inheritDoc}
     */
    public function getTableName()
    {
        return $this->manager->getTableName();
    }

    /**
     * {@inheritDoc}
     */
    public function getConnection()
    {
        return $this->manager->getConnection();
    }

    /**
     * {@inheritDoc}
     */
    public function countStates()
    {
        return $this->manager->countStates();
    }

    /**
     * {@inheritDoc}
     */
    public function cleanup($maxAge)
    {
        $this->manager->cleanup($maxAge);
    }

    /**
     * {@inheritDoc}
     */
    public function cancel(MessageInterface $message)
    {
        $this->manager->cancel($message);
    }

    /**
     * {@inheritDoc}
     */
    public function restart(MessageInterface $message)
    {
        return $this->manager->restart($message);
    }

    /**
     * {@inheritDoc}
     */
    public function findByAttempts(array $types, $state, $batchSize, $maxAttempts = null, $attemptDelay = 10)
    {
        return $this->manager->findByAttempts($types, $state, $batchSize, $maxAttempts, $attemptDelay);
    }

    /**
     * @param array $criteria
     * @param int   $page
     * @param int   $limit
     * @param array $sort
     * @return \Sonata\DatagridBundle\Pager\PagerInterface
     * @throws \Exception When invoked
     */
    public function getPager(array $criteria, $page, $limit = 10, array $sort = array())
    {
        // TODO: Implement getPager() method.
        throw new \Exception('Not implemented!');
    }
}