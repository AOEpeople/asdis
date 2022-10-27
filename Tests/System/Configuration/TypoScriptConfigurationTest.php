<?php

namespace Aoe\Asdis\Tests\System\Configuration;

use Aoe\Asdis\System\Configuration\Exception\InvalidTypoScriptSetting;
use Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists;
use Aoe\Asdis\System\Configuration\TypoScriptConfiguration;
use Nimut\TestingFramework\TestCase\UnitTestCase;

class TypoScriptConfigurationTest extends UnitTestCase
{
    /**
     * @var TypoScriptConfiguration
     */
    private $typoScriptConfiguration;

    /**
     * (non-PHPdoc)
     */
    protected function setUp(): void
    {
        $this->typoScriptConfiguration = $this->getMockBuilder(TypoScriptConfiguration::class)
            ->setMethods(['getTypoScriptConfigurationArray'])
            ->getMock();
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     */
    public function testGetSetting()
    {
        $this->expectException(TypoScriptSettingNotExists::class);

        $this->typoScriptConfiguration->getSetting('xy');
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     * @doesNotPerformAssertions
     */
    public function testGetSettingsWithConfig()
    {
        $config = [
            'logger.' => [
                'severity' => 1,
            ],
        ];
        $this->typoScriptConfiguration
            ->method('getTypoScriptConfigurationArray')
            ->will($this->returnValue($config));

        $this->typoScriptConfiguration->getSetting('logger.severity');
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     * @doesNotPerformAssertions
     */
    public function testGetSettingsWithSubtypeConfig()
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
            ->will($this->returnValue($config));

        $this->typoScriptConfiguration->getSetting('logger.severity', '', true);
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     */
    public function testGetSettingsWithInvalidConfig()
    {
        $this->expectException(InvalidTypoScriptSetting::class);

        $config = [
            'logger.' => [
                'severity' => 1,
            ],
        ];
        $this->typoScriptConfiguration
            ->method('getTypoScriptConfigurationArray')
            ->will($this->returnValue($config));

        $this->typoScriptConfiguration->getSetting('logger.severity', 'array');
    }
}
