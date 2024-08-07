<?php

namespace Aoe\Asdis\Tests\System\Configuration;

use Aoe\Asdis\System\Configuration\Exception\InvalidTypoScriptSetting;
use Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists;
use Aoe\Asdis\System\Configuration\TypoScriptConfiguration;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class TypoScriptConfigurationTest extends UnitTestCase
{
    /**
     * @var @var MockObject&\TypoScriptConfiguration
     */
    private MockObject $typoScriptConfiguration;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->typoScriptConfiguration = $this->getMockBuilder(TypoScriptConfiguration::class)
            ->onlyMethods(['getTypoScriptConfigurationArray'])
            ->getMock();
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     */
    public function testGetSetting(): void
    {
        $this->expectException(TypoScriptSettingNotExists::class);
        $this->typoScriptConfiguration->getSetting('xy');
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     */
    public function testGetSettingsWithConfig(): void
    {
        $config = [
            'logger.' => [
                'severity' => 1,
            ],
        ];
        $this->typoScriptConfiguration
            ->method('getTypoScriptConfigurationArray')
            ->willReturn($config);

        $this->typoScriptConfiguration->getSetting('logger.severity');
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     */
    public function testGetSettingsWithSubtypeConfig(): void
    {
        $config = [
            'logger.' => [
                'severity.' => [
                    'bla' => 'blub',
                ],
            ],
        ];
        $this->typoScriptConfiguration
            ->method('getTypoScriptConfigurationArray')
            ->willReturn($config);

        $this->typoScriptConfiguration->getSetting('logger.severity', '', true);
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     */
    public function testGetSettingsWithInvalidConfig(): void
    {
        $this->expectException(InvalidTypoScriptSetting::class);

        $config = [
            'logger.' => [
                'severity' => 1,
            ],
        ];
        $this->typoScriptConfiguration
            ->method('getTypoScriptConfigurationArray')
            ->willReturn($config);

        $this->typoScriptConfiguration->getSetting('logger.severity', 'array');
    }
}
