<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Dinosaur;
use App\Enum\HealthStatus;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class DinosaurTest extends TestCase
{
     public function testCanGetAndSetData(): void
     {
         $dino = new Dinosaur(
             name: 'Big Eaty',
             genus: 'Tyrannosaurus',
             length: 15,
             enclosure: 'Paddock A'
         );


        self::assertSame('Big Eaty', $dino->getName());
        self::assertSame('Tyrannosaurus', $dino->getGenus());
        self::assertSame(15, $dino->getLength());
        self::assertSame('Paddock A', $dino->getEnclosure());
     }

     #[DataProvider('sizeDescriptionProvider')]
     public function testDinoHasCorrectSizeDescriptionFromLength(int $length, string $expectedSize): void
     {
            $dino = new Dinosaur(
                name: 'Big Eaty',
                length: $length,
            );

            self:self::assertSame($expectedSize, $dino->getSizeDescription());
     }

     public function sizeDescriptionProvider()
     {
        yield '10 Meter Large Dino' => [10, 'Large'];
        yield '5 Meter Medium Dino' => [5, 'Medium'];
        yield '1 Meter Small Dino' => [1, 'Small'];
     }

     public function testIsAcceptingVisitorsByDefault(): void
     {
         $dino = new Dinosaur('Dennis');

         self::assertTrue($dino->isAcceptingVisitors());
     }

     #[DataProvider('healthStatusProvider')]
     public function testIsAcceptingVisitorsOnHealthStatus(HealthStatus $healthStatus, bool $expectedVisitorsStatus): void
     {
        $dino = new Dinosaur(name: 'Bumpy', health: $healthStatus);

        self::assertSame($expectedVisitorsStatus, $dino->isAcceptingVisitors());
     }

    public function healthStatusProvider(): \Generator
    {
        yield 'Sick dino is not accepting visitors' => [HealthStatus::SICK, false];
        yield 'Hungry dino is accepting visitors' => [HealthStatus::HUNGRY, true];
    }
}