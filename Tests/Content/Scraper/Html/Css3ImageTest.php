<?php
/**
 * @package    asdis
 * @subpackage Tests
 */

/**
 * Tx_Asdis_Content_Scraper_Html_CssAttribute test case.
 */
class Tx_Asdis_Content_Scraper_Html_Css3ImageTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Scraper_Html_Css3Image
	 */
	private $css3Image;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->css3Image = new Tx_Asdis_Content_Scraper_Html_Css3Image();
	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->css3Image = NULL;
	}

	/**
	 * Tests Tx_Asdis_Content_Scraper_Css_Url->scrape()
	 * @test
	 */
	public function scrape() {
        $assetFactory = $this->getMockBuilder('Tx_Asdis_Domain_Model_Asset_Factory')
            ->setMethods(array('createAssetsFromPaths'))
            ->disableOriginalConstructor()
            ->getMock();
        $assetFactory->expects($this->once())->method('createAssetsFromPaths')->with(array(
            '//my-domain.local/fileadmin/550px.jpg',
            '//my-domain.local/fileadmin/250px.jpg',
            '//my-domain.local/fileadmin/250px.jpg',
            '//my-domain.local/fileadmin/1000px.jpg',
            '//my-domain.local/fileadmin/1500px.jpg',
            '//my-domain.local/fileadmin/1500px.jpg'
        ));
        $this->css3Image->injectAssetFactory($assetFactory);
		$this->css3Image->scrape(
            '<div data-src-desktop="//my-domain.local/fileadmin/550px.jpg"></div>' .
            '<div data-src-phone="//my-domain.local/fileadmin/250px.jpg"></div>' .
            '<div data-src-phone-highres="//my-domain.local/fileadmin/250px.jpg"></div>' .
            '<div data-src-desktop="//my-domain.local/fileadmin/1000px.jpg" data-src-desktop-highres="//my-domain.local/fileadmin/1500px.jpg"></div>' .
            '<img src="//my-domain.local/fileadmin/1000px.jpg" data-src-desktop-highres="//my-domain.local/fileadmin/1500px.jpg" />'
        );
	}
}