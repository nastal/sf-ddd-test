<?php

namespace App\Tests\Verification\Domain\Service;

use App\Shared\Domain\Entity\Type;
use App\Verification\Domain\Aggregate\Code;
use App\Verification\Domain\Aggregate\Subject;
use App\Verification\Domain\Aggregate\UserFingerprint;
use App\Verification\Domain\Aggregate\Verification;
use App\Verification\Domain\Exception\ValidationFailedException;
use App\Verification\Domain\Exception\VerificationAlreadyConfirmedException;
use App\Verification\Domain\Exception\VerificationExpiredException;
use App\Verification\Domain\Exception\VerificationException;
use App\Verification\Domain\Repository\VerificationRepositoryInterface;
use App\Verification\Domain\Service\VerificationService;
use App\Verification\Infrastructure\Doctrine\Repository\VerificationRepository;
use PHPUnit\Framework\TestCase;


//todo WIP
class VerificationServiceTest extends TestCase
{
    private VerificationRepositoryInterface $repository;
    private VerificationService $service;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(VerificationRepository::class);
        $this->service = new VerificationService($this->repository);
    }

    public function testCreateVerification()
    {
        $subject = new Subject('test@example.com', Type::Email);
        $code = new Code(123456);
        $userAgent = 'test fingerprint';
        $userIp = '::1';
        $userFingerprint = new UserFingerprint($userAgent, $userIp);

        $verification = new Verification($subject, $code, $userFingerprint);

        $this->service->createVerification($verification);

        $savedVerification = $this->repository->get($verification->getUuid());

        $this->assertTrue($savedVerification->getSubject()->getIdentity() === $subject->getIdentity());

    }

    public function testCreateVerificationThrowsExceptionOnDuplicatePendingVerification()
    {
        $subject = new Subject('test@example.com');
        $code = new Code(123456);
        $verification = new Verification($subject, $code);

        $this->repository->method('findPendingIdentity')
            ->willReturn([$verification]);

        $this->expectException(VerificationException::class);
        $this->service->createVerification($verification);
    }

    public function testConfirm()
    {
        $subject = new Subject('test@example.com');
        $code = new Code(123456);
        $verification = new Verification($subject, $code);

        $this->repository->method('findPendingIdentity')
            ->willReturn([]);

        $this->repository->expects($this->once())
            ->method('confirm')
            ->with($verification->getUuid());

        $this->service->confirm($verification, 123456);
        $this->assertTrue($verification->isConfirmed());
    }

    public function testConfirmThrowsExceptionOnAlreadyConfirmedVerification()
    {
        $subject = new Subject('test@example.com');
        $code = new Code(123456);
        $verification = new Verification($subject, $code);
        $verification->setConfirmed();

        $this->repository->method('findPendingIdentity')
            ->willReturn([]);

        $this->expectException(VerificationAlreadyConfirmedException::class);
        $this->service->confirm($verification, 123456);
    }

    public function testConfirmThrowsExceptionOnExpiredVerification()
    {
        $subject = new Subject('test@example.com');
        $code = new Code(123456);
        $verification = new Verification($subject, $code);

        $verification->setCreatedAt(new \DateTimeImmutable('-10 minutes'));

        $this->repository->method('findPendingIdentity')
            ->willReturn([]);

        $this->expectException(VerificationExpiredException::class);
        $this->service->confirm($verification, 123456);
    }

    public function testConfirmThrowsExceptionOnMaxInvalidAttempts(): void
    {
        $subject = new Subject('john.doe@example.com');
        $code = new VerificationCode('123456');

        $verification = new Verification(Uuid::uuid4(), $subject, $code, 2);
        $verification->setInvalidAttempts(2);

        $this->verificationRepositoryMock->expects(self::once())
            ->method('find')
            ->with($verification->getUuid())
            ->willReturn($verification);

        $this->expectException(ValidationFailedException::class);
        $this->expectExceptionMessage('No permission to confirm verification');

        $this->verificationService->confirm($verification, $code->getCode());
    }

}
