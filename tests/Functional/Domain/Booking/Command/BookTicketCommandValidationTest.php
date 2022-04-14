<?php

namespace App\Tests\Functional\Domain\Booking\Command;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Tests\Functional\ViolationAssertTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Validator\TraceableValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BookTicketCommandValidationTest extends WebTestCase
{
    use ViolationAssertTrait;

    private BookTicketCommand $command;

    private TraceableValidator $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->command = new BookTicketCommand();

        $this->validator = $this->getContainer()->get(ValidatorInterface::class);
    }

    public function testValidClientName(): void
    {
        $this->command->clientName = 'Андрей';

        $violations = $this->validator->validate($this->command);

        self::assertEquals(0, count($violations));
    }

    public function testInvalidClientName(): void
    {
        $this->command->clientName = 'Fake name';

        $violations = $this->validator->validate($this->command);

        $this->assertPropertyIsInvalid('clientName', 'The name must contain only Russian letters.', $violations);
    }

    public function testValidClientPhone(): void
    {
        $this->command->clientPhoneNumber = '7894561237';

        $violations = $this->validator->validate($this->command);

        self::assertEquals(0, count($violations));
    }

    public function testInvalidClientPhone(): void
    {
        $this->command->clientPhoneNumber = '123456789';

        $violations = $this->validator->validate($this->command);

        $this->assertPropertyIsInvalid(
            'clientPhoneNumber',
            'The number must be 10 digits long and must not include the following characters: \'+\' \'-\' \'*\'',
            $violations,
        );
    }
}
