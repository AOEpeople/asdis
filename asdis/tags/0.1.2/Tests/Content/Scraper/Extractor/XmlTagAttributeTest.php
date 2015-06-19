<?php

$asdisBaseDir = dirname(__FILE__) . '/../../../../';
require_once $asdisBaseDir . 'Tests/AbstractTestcase.php';
require_once $asdisBaseDir . 'Classes/Content/Scraper/Extractor/XmlTagAttribute.php';

/**
 * Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute tests.
 */
class Tx_Asdis_Content_Scraper_Extractor_XmlTagAttributeTest extends Tx_Asdis_Tests_AbstractTestcase {

	/**
	 * @var Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute
	 */
	private $extractor;

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::setUp()
	 */
	protected function setUp() {
		$this->extractor = new Tx_Asdis_Content_Scraper_Extractor_XmlTagAttribute();
	}

	/**
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestCase::tearDown()
	 */
	protected function tearDown() {
		$this->extractor = NULL;
	}

	/**
	 * @test
	 */
	public function getAttributeFromTag() {
		$path1 = 'uploads/pics/foo.jpg';
		$path2 = 'typo3temp/tx_foo/bar.gif';
		$content = '<div class="foo">
			<img src="'.$path1.'" style="width: 15px;" />
			<p>
				<img src="'.$path2.'" />
			</p>
		</div>';
		$hits = $this->extractor->getAttributeFromTag('img', 'src', $content);
		$this->assertInternalType('array', $hits);
		$this->assertInternalType('array', $hits['paths']);
		$this->assertInternalType('array', $hits['masks']);
		$this->assertEquals(2, sizeof($hits['paths']));
		$this->assertEquals(2, sizeof($hits['masks']));
		$this->assertEquals($path1, $hits['paths'][0]);
		$this->assertEquals('"', $hits['masks'][0]);
		$this->assertEquals($path2, $hits['paths'][1]);
		$this->assertEquals('"', $hits['masks'][1]);
	}

	/**
	 * @test
	 */
	public function getAttributeFromTagWithRequiredOtherAttributes() {
		$path1 = 'uploads/pics/foo.jpg';
		$path2 = 'typo3temp/tx_foo/bar.gif';
		$content = '<div>
			<input type="image" src="'.$path1.'" />
			<input src="'.$path2.'" />
		</div>';
		$hits = $this->extractor->getAttributeFromTag('input', 'src', $content, array('type' => 'image'));
        $this->assertInternalType('array', $hits);
        $this->assertInternalType('array', $hits['paths']);
        $this->assertInternalType('array', $hits['masks']);
        $this->assertEquals(1, sizeof($hits['paths']));
        $this->assertEquals(1, sizeof($hits['masks']));
		$this->assertEquals($path1, $hits['paths'][0]);
		$this->assertEquals('"', $hits['masks'][0]);
	}
}

