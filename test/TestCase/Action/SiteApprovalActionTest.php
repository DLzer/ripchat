<?php

namespace App\Test\TestCase\Action;

use App\Test\AppTestTrait;
use PHPUnit\Framework\TestCase;
use App\Domain\Site\Service\SiteReaderService;

final class SiteApprovalActionTest extends \PHPUnit\Framework\TestCase
{

    /**
     * Test.
     *
     * @param array $expected The expected result
     *
     * @return void
     */
    public function testSiteReaderService(): void
    {


        $data = [
            'data' => [
                "site" => "volum8.com",
                "process_status" => "successful",
                "approval" => "approved"
            ]
        ];
        $data = json_encode($data);

        $expected = [
            'data' => [
                "site" => "volum8.com",
                "process_status" => "successful",
                "approval" => "approved"
            ]
        ];

        // Asserts
        $this->assertJsonData($data, $expected);
    }

    /**
     * Verify that the given array is an exact match for the JSON returned.
     *
     * @param ResponseInterface $response The response
     * @param array $expected The expected array
     *
     * @return void
     */
    protected function assertJsonData(
        $data, 
        array $expected
    ): void {
        $actual = (string)$data;
        $this->assertJson($actual);
        $this->assertSame($expected, (array)json_decode($actual, true));
    }

}