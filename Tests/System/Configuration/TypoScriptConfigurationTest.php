<?php
namespace Aoe\Asdis\Tests\System\Configuration;

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
    protected function setUp()
    {
        $this->typoScriptConfiguration = $this->getMockBuilder(TypoScriptConfiguration::class)
            ->setMethods(['getTypoScriptConfigurationArray'])
            ->getMock();		
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     * @test
     * @expectedException Aoe\Asdis\System\Configuration\Exception\TypoScriptSettingNotExists
     */
    public function getSetting()
    {
        $this->typoScriptConfiguration->getSetting('xy');
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     * @test
     * @doesNotPerformAssertions
     */
    public function getSettingsWithConfig()
    {
        $config = [
            'logger.' => [
                'severity' => 1,
            ],
        ];
        $this->typoScriptConfiguration
            ->expects($this->any())
            ->method('getTypoScriptConfigurationArray')
            ->will($this->returnValue($config));

        $this->typoScriptConfiguration->getSetting('logger.severity');
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     * @test
     * @doesNotPerformAssertions
     */
    public function getSettingsWithSubtypeConfig()
    {
        $config = [
            'logger.' => [
                'severity.' => [
                    'bla' => 'blub',
                ],
            ],
        ];
        $this->typoScriptConfiguration
            ->expects($this->any())
            ->method('getTypoScriptConfigurationArray')
            ->will($this->returnValue($config));

        $this->typoScriptConfiguration->getSetting('logger.severity', '', true);
    }

    /**
     * Tests Aoe\Asdis\System\Configuration\TypoScriptConfiguration->getSetting()
     * @test
     * @expectedException Aoe\Asdis\System\Configuration\Exception\InvalidTypoScriptSetting
     */
    public function getSettingsWithInvalidConfig()
    {
        $config = [
            'logger.' => [
                'severity' => 1,
            ],
        ];
        $this->typoScriptConfiguration
            ->expects($this->any())
            ->method('getTypoScriptConfigurationArray')
            ->will($this->returnValue($config));
            
        $this->typoScriptConfiguration->getSetting('logger.severity', 'array');
    }
}
