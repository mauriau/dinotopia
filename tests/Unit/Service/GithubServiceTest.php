<?php

namespace App\Tests\Unit\Service;

use App\Enum\HealthStatus;
use App\Service\GithubService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GithubServiceTest extends TestCase
{
    #[DataProvider('dinoNameProvider')]
    public function testGetHealthReportReturnsCorrectHealthStatusForDino(HealthStatus $expectedStatus, string $dinoName): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockHttpClient = $this->createMock(HttpClientInterface::class);
        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockResponse->method('toArray')->willReturn([
            [
                'title' => 'Daisy is sick',
                'labels' => [
                    [
                        'name' => 'Status: Sick',
                    ],
                ],
            ],
            [
                'title' => 'Maverick is healthy',
                'labels' => [
                    [
                        'name' => 'Status: Healthy',
                    ],
                ],
            ],
        ]);
        $mockResponse
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(200);

        $mockHttpClient
            ->expects(self::once())
            ->method('request')
            ->with('GET', 'https://api.github.com/repos/SymfonyCasts/dino-park/issues')
            ->willReturn($mockResponse);

        $service = new GithubService($mockLogger, $mockHttpClient);

        self::assertSame($expectedStatus, $service->getHealthReport($dinoName));

    }

    public function dinoNameProvider(): \Generator
    {
        yield 'Sick Dino' => [
            HealthStatus::SICK, 'Daisy',
        ];
        yield 'Healthy Dino' => [
            HealthStatus::HEALTHY, 'Maverick',
        ];
    }

}
