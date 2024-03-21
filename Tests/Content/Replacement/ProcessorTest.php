<?php

namespace Aoe\Asdis\Tests\Content\Replacement;

use Aoe\Asdis\Content\Replacement\Map;
use Aoe\Asdis\Content\Replacement\Processor;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class ProcessorTest extends UnitTestCase
{
    private Processor $processor;

    protected function setUp(): void
    {
        $this->processor = new Processor();
    }

    public function testReplace(): void
    {
        $content = '<script type="text/css" src="typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles.css" /><script type="text/css" src="/typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles.css" />';
        $result = '<script type="text/css" src="http://media9.dev.myproject.com/typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles.css" /><script type="text/css" src="http://media4.dev.myproject.com/typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles.css" />';
        $source1 = '~/?typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles\.css~is';
        $target1 = 'http://media9.dev.myproject.com/typo3temp/js_css_optimizer/js_css_optimizer808ed94db016bc2941aa4b6de7f281664e40509f_b11ce65960acc0970b4bd1b7dc2292c85b9d4b4e_bundled_cssFiles.css';
        $source2 = '~/?typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles\.css~is';
        $target2 = 'http://media4.dev.myproject.com/typo3temp/js_css_optimizer/_compressed_b8556e54a9173d519e2bf8851b6ec9778fc21495_js_css_optimizer3e8d68f9771f88ee7239129f8ffb85eb0e257769_e720b5b16198fa7190b9c5d8d49e717a98e79a7e_bundled_cssFiles.css';

        $map = new Map();
        $map->addMapping($source1, $target1);
        $map->addMapping($source2, $target2);

        $this->assertSame($result, $this->processor->replace($map, $content));
    }
}
