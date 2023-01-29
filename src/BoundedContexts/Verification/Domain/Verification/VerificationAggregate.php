<?php

namespace App\BoundedContexts\Verification\Domain\Verification;


use App\BoundedContexts\Verification\Domain\Verification\VerificationSubject;
use App\BoundedContexts\Verification\Domain\Verification\VerificationId;
use App\BoundedContexts\Verification\Domain\Verification\VerificationTypeEnum;

class VerificationAggregate
{
    private VerificationId $id;
    private VerificationSubject $subject;
    private bool $confirmed;
    private int $code;
    private string $userInfo;

    private \DateTimeImmutable $created_at;

    public function __construct(VerificationId $id, VerificationSubject $subject, $confirmed, $code, $userInfo, $created_at)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->confirmed = $confirmed;
        $this->code = $code;
        $this->userInfo = $userInfo;
        $this->created_at = $created_at;
    }

    public function create(VerificationId $id, VerificationSubject $subject, $confirmed, $code, $userInfo, $created_at): self
    {

        if ($subject->getIdentity() === null) {
            throw new \DomainException("Subject identity can't be null");
        }

        if (!in_array($subject->getType(), VerificationTypeEnum::cases())) {
            throw new \DomainException("Subject type is not valid");
        }

        return new self($id, $subject, $confirmed, $code, $userInfo, $created_at);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getConfirmed()
    {
        return $this->confirmed;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }
}