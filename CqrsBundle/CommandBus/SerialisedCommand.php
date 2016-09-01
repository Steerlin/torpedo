<?php


namespace Torpedo\CqrsBundle\CommandBus;


use Torpedo\CQRS\Command\Command;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
final class SerialisedCommand
{
    const TO_DO = 'TO DO';
    const IN_PROGRESS = 'IN PROGRESS';
    const FAILED =  'FAILED';

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $sequence;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $serialisedCommand;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $failCount = 0;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $exceptionMessage;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $queueName;

    public function __construct(Command $command, string $queueName)
    {
        $this->queueName = $queueName;
        $this->serialisedCommand = serialize($command);
        $this->status = self::TO_DO;
    }

    public function getCommand(): Command
    {
        return unserialize($this->serialisedCommand);
    }

    public function getId(): int
    {
        return $this->sequence;
    }

    public function markInProgress()
    {
        $this->status = self::IN_PROGRESS;
    }

    public function markFailed(string $exceptionMessage = '')
    {
        $this->status = self::FAILED;
        $this->failCount++;
        $this->exceptionMessage = $exceptionMessage;
    }

}
